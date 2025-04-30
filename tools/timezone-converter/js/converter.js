/**
 * タイムゾーン変換の機能を管理するモジュール
 */

/**
 * 時間変換を実行
 */
export function convertTime(elements, config) {
  let dateValue, timeValue;

  // 一括入力フィールドから入力された場合
  if (elements.datetimeInput && elements.datetimeInput.value.trim()) {
    const datetimeStr = elements.datetimeInput.value.trim();
    const parsedDateTime = parseDatetimeString(datetimeStr);

    if (parsedDateTime) {
      // 日付と時間のフィールドに値をセット
      elements.dateInput.value = parsedDateTime.date;
      elements.timeInput.value = parsedDateTime.time;

      dateValue = parsedDateTime.date;
      timeValue = parsedDateTime.time;
    } else {
      alert(
        "対応していない日時フォーマットです。以下のいずれかの形式で入力してください：\n" +
          "YYYY-MM-DD HH:MM\n" +
          "YYYY/MM/DD HH:MM\n" +
          "MM/DD/YYYY HH:MM\n" +
          "DD.MM.YYYY HH:MM"
      );
      return;
    }
  } else {
    // 個別フィールドから入力された場合
    // 入力チェック
    if (!elements.dateInput.value || !elements.timeInput.value) {
      alert("日付と時間を入力してください。");
      return;
    }

    // 日付形式チェック (YYYY-MM-DD)
    dateValue = elements.dateInput.value.trim();
    const dateRegex = /^\d{4}-\d{2}-\d{2}$/;
    if (!dateRegex.test(dateValue)) {
      alert("日付はYYYY-MM-DD形式で入力してください。例: 2025-04-30");
      return;
    }

    // 時間形式チェック (HH:MM)
    timeValue = elements.timeInput.value.trim();
    const timeRegex = /^([01][0-9]|2[0-3]):([0-5][0-9])$/;
    if (!timeRegex.test(timeValue)) {
      alert("時間はHH:MM形式で入力してください。例: 15:30");
      return;
    }

    // フォーム入力からシンプル入力の値を更新
    if (elements.datetimeInput) {
      elements.datetimeInput.value = `${dateValue} ${timeValue}`;
    }
  }

  const sourceTimezoneValue = elements.sourceTimezone.value;
  const targetTimezoneValue = elements.targetTimezone.value;

  // 日時の各要素を解析
  const year = parseInt(dateValue.substring(0, 4), 10);
  const month = parseInt(dateValue.substring(5, 7), 10) - 1; // JavaScriptの月は0から始まる
  const day = parseInt(dateValue.substring(8, 10), 10);
  const hour = parseInt(timeValue.substring(0, 2), 10);
  const minute = parseInt(timeValue.substring(3, 5), 10);

  // 入力された元の日時を作成（タイムゾーン情報なし）
  const originalDate = new Date(year, month, day, hour, minute, 0);

  // 入力日時が無効な場合
  if (isNaN(originalDate.getTime())) {
    alert("無効な日付または時間です。正しい値を入力してください。");
    return;
  }

  // 元のタイムゾーン情報（曜日付き日付）を作成
  const dayOfWeek = getDayOfWeekInJapanese(originalDate.getDay());
  const sourceDateStr = `${year}年${month + 1}月${day}日${dayOfWeek}`;
  const sourceTimeStr = `${timeValue}`;

  // 変換先のタイムゾーンでの日時を計算
  const convertedDateTime = convertBetweenTimezones(
    year,
    month,
    day,
    hour,
    minute,
    sourceTimezoneValue,
    targetTimezoneValue
  );

  // 結果を表示
  elements.resultContainer.classList.remove("hidden");

  const sourceCityName =
    config.cityNames[sourceTimezoneValue] || sourceTimezoneValue;
  const targetCityName =
    config.cityNames[targetTimezoneValue] || targetTimezoneValue;

  elements.resultContent.innerHTML = `
    <p><strong>${sourceCityName}:</strong> ${sourceDateStr} ${sourceTimeStr}</p>
    <p><strong>${targetCityName}:</strong> ${convertedDateTime.formattedDate} ${convertedDateTime.formattedTime}</p>
  `;

  // URLのハッシュを更新（シェア用）
  const dateTimeStr = `${dateValue}T${timeValue}:00`;
  updateUrlHash(sourceTimezoneValue, targetTimezoneValue, dateTimeStr);
}

/**
 * 曜日を日本語で取得
 */
function getDayOfWeekInJapanese(dayIndex) {
  const days = [
    "日曜日",
    "月曜日",
    "火曜日",
    "水曜日",
    "木曜日",
    "金曜日",
    "土曜日",
  ];
  return days[dayIndex];
}

/**
 * タイムゾーン間で日時を変換
 */
function convertBetweenTimezones(
  year,
  month,
  day,
  hour,
  minute,
  sourceTimezone,
  targetTimezone
) {
  // 同じタイムゾーンの場合は変換せずに元の値を使用
  if (sourceTimezone === targetTimezone) {
    const formattedDate = `${year}年${
      month + 1
    }月${day}日${getDayOfWeekInJapanese(new Date(year, month, day).getDay())}`;
    const formattedTime = `${String(hour).padStart(2, "0")}:${String(
      minute
    ).padStart(2, "0")}`;

    return {
      date: new Date(year, month, day, hour, minute),
      formattedDate: formattedDate,
      formattedTime: formattedTime,
    };
  }

  // UTCでの日時を作成
  let utcTime;

  // 元のタイムゾーンがUTCの場合は直接UTCとして扱う
  if (sourceTimezone === "UTC") {
    utcTime = Date.UTC(year, month, day, hour, minute, 0);
  } else {
    // UTCでない場合は、タイムゾーンオフセットを考慮してUTC時間を計算
    const sourceOffset = getTimezoneOffset(sourceTimezone); // 分単位
    utcTime =
      Date.UTC(year, month, day, hour, minute, 0) - sourceOffset * 60 * 1000;
  }

  // 目標タイムゾーンの時間を計算
  const targetOffset = getTimezoneOffset(targetTimezone); // 分単位
  const targetTime = new Date(utcTime + targetOffset * 60 * 1000);

  // フォーマットした日付と時間を返す
  const formattedDate = `${targetTime.getUTCFullYear()}年${
    targetTime.getUTCMonth() + 1
  }月${targetTime.getUTCDate()}日${getDayOfWeekInJapanese(
    targetTime.getUTCDay()
  )}`;
  const formattedTime = `${String(targetTime.getUTCHours()).padStart(
    2,
    "0"
  )}:${String(targetTime.getUTCMinutes()).padStart(2, "0")}`;

  return {
    date: targetTime,
    formattedDate: formattedDate,
    formattedTime: formattedTime,
  };
}

/**
 * タイムゾーンの標準オフセットを取得（分単位）
 */
function getTimezoneOffset(timezone) {
  // 一般的なタイムゾーンのオフセット（分単位、UTCからの差分）
  const timezoneOffsets = {
    UTC: 0,
    "Europe/London": 0,
    "Europe/Paris": 60,
    "Europe/Berlin": 60,
    "Europe/Moscow": 180,
    "Asia/Tokyo": 540,
    "Asia/Shanghai": 480,
    "Asia/Seoul": 540,
    "Australia/Sydney": 600,
    "Pacific/Auckland": 720,
    "America/New_York": -240,
    "America/Chicago": -300,
    "America/Denver": -360,
    "America/Los_Angeles": -420,
    "America/Anchorage": -480,
    "Pacific/Honolulu": -600,
  };

  // 一般的なタイムゾーンにある場合はそのオフセットを返す
  if (timezoneOffsets[timezone] !== undefined) {
    return timezoneOffsets[timezone];
  }

  // 一般的でないタイムゾーンの場合は、現在時刻でオフセットを計算
  const now = new Date();
  const formatter = new Intl.DateTimeFormat("en-US", {
    timeZone: timezone,
    timeZoneName: "longOffset",
  });

  const formattedDate = formatter.format(now);
  const match = formattedDate.match(/GMT([+-])(\d{2}):?(\d{2})?/);

  if (match) {
    const sign = match[1] === "-" ? -1 : 1;
    const hours = parseInt(match[2], 10) || 0;
    const minutes = parseInt(match[3], 10) || 0;
    return sign * (hours * 60 + minutes);
  }

  // オフセットが取得できなかった場合
  return 0;
}

/**
 * 日付部分をフォーマットして文字列で返す
 */
function formatDateInTimezone(date, locale, timezone) {
  const options = {
    timeZone: timezone,
    weekday: "long",
    year: "numeric",
    month: "long",
    day: "numeric",
  };
  return new Intl.DateTimeFormat(locale, options).format(date);
}

/**
 * 時間部分をフォーマットして文字列で返す
 */
function formatTimeInTimezone(date, locale, timezone) {
  const options = {
    timeZone: timezone,
    hour: "2-digit",
    minute: "2-digit",
    hour12: false,
  };
  return new Intl.DateTimeFormat(locale, options).format(date);
}

/**
 * URLハッシュを更新
 */
export function updateUrlHash(sourceTimezone, targetTimezone, dateTimeStr) {
  const params = new URLSearchParams();
  params.set("source", sourceTimezone);
  params.set("target", targetTimezone);
  params.set("datetime", dateTimeStr);

  window.location.hash = params.toString();
}

/**
 * URLハッシュから変換設定を読み込む
 */
export function loadFromUrlHash(elements, config) {
  if (!window.location.hash) return false;

  const params = new URLSearchParams(window.location.hash.substring(1));

  const source = params.get("source");
  const target = params.get("target");
  const datetime = params.get("datetime");

  if (!source || !target || !datetime) return false;

  // 日時が有効な形式かチェック
  const dateTimeParts = datetime.split("T");
  if (dateTimeParts.length !== 2) return false;

  const date = dateTimeParts[0]; // YYYY-MM-DD 形式
  const time = dateTimeParts[1].substring(0, 5); // HH:MM の部分だけ

  // 日付と時間が正しい形式かチェック
  const dateRegex = /^\d{4}-\d{2}-\d{2}$/;
  const timeRegex = /^([01][0-9]|2[0-3]):([0-5][0-9])$/;

  if (!dateRegex.test(date) || !timeRegex.test(time)) {
    return false;
  }

  // フォームに値をセット
  elements.dateInput.value = date;
  elements.timeInput.value = time;
  elements.sourceTimezone.value = source;
  elements.targetTimezone.value = target;

  // 変換を実行
  convertTime(elements, config);

  return true;
}

/**
 * URLをクリップボードにコピー
 */
export function copyUrlToClipboard() {
  const url = window.location.href;

  navigator.clipboard
    .writeText(url)
    .then(() => {
      alert("URLをクリップボードにコピーしました。");
    })
    .catch((err) => {
      console.error("URLのコピーに失敗しました:", err);
      alert("URLのコピーに失敗しました。");
    });
}

/**
 * 複数のフォーマットの日時文字列をパースする
 */
export function parseDatetimeString(datetimeStr) {
  // 空文字列のチェック
  if (!datetimeStr || !datetimeStr.trim()) {
    return null;
  }

  datetimeStr = datetimeStr.trim();

  // YYYY-MM-DD HH:MM 形式
  let match = datetimeStr.match(
    /^(\d{4})-(\d{1,2})-(\d{1,2})\s+(\d{1,2}):(\d{1,2})$/
  );
  if (match) {
    const [_, year, month, day, hour, minute] = match;
    return {
      date: `${year}-${month.padStart(2, "0")}-${day.padStart(2, "0")}`,
      time: `${hour.padStart(2, "0")}:${minute.padStart(2, "0")}`,
    };
  }

  // YYYY/MM/DD HH:MM 形式
  match = datetimeStr.match(
    /^(\d{4})\/(\d{1,2})\/(\d{1,2})\s+(\d{1,2}):(\d{1,2})$/
  );
  if (match) {
    const [_, year, month, day, hour, minute] = match;
    return {
      date: `${year}-${month.padStart(2, "0")}-${day.padStart(2, "0")}`,
      time: `${hour.padStart(2, "0")}:${minute.padStart(2, "0")}`,
    };
  }

  // MM/DD/YYYY HH:MM 形式
  match = datetimeStr.match(
    /^(\d{1,2})\/(\d{1,2})\/(\d{4})\s+(\d{1,2}):(\d{1,2})$/
  );
  if (match) {
    const [_, month, day, year, hour, minute] = match;
    return {
      date: `${year}-${month.padStart(2, "0")}-${day.padStart(2, "0")}`,
      time: `${hour.padStart(2, "0")}:${minute.padStart(2, "0")}`,
    };
  }

  // DD.MM.YYYY HH:MM 形式
  match = datetimeStr.match(
    /^(\d{1,2})\.(\d{1,2})\.(\d{4})\s+(\d{1,2}):(\d{1,2})$/
  );
  if (match) {
    const [_, day, month, year, hour, minute] = match;
    return {
      date: `${year}-${month.padStart(2, "0")}-${day.padStart(2, "0")}`,
      time: `${hour.padStart(2, "0")}:${minute.padStart(2, "0")}`,
    };
  }

  // 一致しない場合
  return null;
}

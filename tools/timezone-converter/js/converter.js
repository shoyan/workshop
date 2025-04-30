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
      alert('対応していない日時フォーマットです。以下のいずれかの形式で入力してください：\n' +
            'YYYY-MM-DD HH:MM\n' +
            'YYYY/MM/DD HH:MM\n' +
            'MM/DD/YYYY HH:MM\n' +
            'DD.MM.YYYY HH:MM');
      return;
    }
  } else {
    // 個別フィールドから入力された場合
    // 入力チェック
    if (!elements.dateInput.value || !elements.timeInput.value) {
      alert('日付と時間を入力してください。');
      return;
    }
    
    // 日付形式チェック (YYYY-MM-DD)
    dateValue = elements.dateInput.value.trim();
    const dateRegex = /^\d{4}-\d{2}-\d{2}$/;
    if (!dateRegex.test(dateValue)) {
      alert('日付はYYYY-MM-DD形式で入力してください。例: 2025-04-30');
      return;
    }
    
    // 時間形式チェック (HH:MM)
    timeValue = elements.timeInput.value.trim();
    const timeRegex = /^([01][0-9]|2[0-3]):([0-5][0-9])$/;
    if (!timeRegex.test(timeValue)) {
      alert('時間はHH:MM形式で入力してください。例: 15:30');
      return;
    }
  }
  
  const sourceTimezoneValue = elements.sourceTimezone.value;
  const targetTimezoneValue = elements.targetTimezone.value;
  
  // 日時文字列を作成（ISO 8601形式）
  const dateTimeStr = `${dateValue}T${timeValue}:00`;
  
  // 日時オブジェクトを作成（入力はローカルタイムとして解釈）
  const date = new Date(dateTimeStr);
  
  // 無効な日付チェック
  if (isNaN(date.getTime())) {
    alert('無効な日付または時間です。正しい値を入力してください。');
    return;
  }
  
  // 元のタイムゾーンの情報を取得
  const sourceDateOptions = {
    timeZone: sourceTimezoneValue,
    weekday: 'long',
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  };
  
  const sourceTimeOptions = {
    timeZone: sourceTimezoneValue,
    hour: '2-digit',
    minute: '2-digit',
    hour12: false
  };
  
  const sourceDate = new Intl.DateTimeFormat('ja-JP', sourceDateOptions).format(date);
  const sourceTime = new Intl.DateTimeFormat('ja-JP', sourceTimeOptions).format(date);
  
  // 変換先のタイムゾーンの情報を取得
  const targetDateOptions = {
    timeZone: targetTimezoneValue,
    weekday: 'long',
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  };
  
  const targetTimeOptions = {
    timeZone: targetTimezoneValue,
    hour: '2-digit',
    minute: '2-digit',
    hour12: false
  };
  
  const targetDate = new Intl.DateTimeFormat('ja-JP', targetDateOptions).format(date);
  const targetTime = new Intl.DateTimeFormat('ja-JP', targetTimeOptions).format(date);
  
  // 結果を表示
  elements.resultContainer.classList.remove('hidden');
  
  const sourceCityName = config.cityNames[sourceTimezoneValue] || sourceTimezoneValue;
  const targetCityName = config.cityNames[targetTimezoneValue] || targetTimezoneValue;
  
  elements.resultContent.innerHTML = `
    <p><strong>${sourceCityName}:</strong> ${sourceDate} ${sourceTime}</p>
    <p><strong>${targetCityName}:</strong> ${targetDate} ${targetTime}</p>
  `;
  
  // URLのハッシュを更新（シェア用）
  updateUrlHash(sourceTimezoneValue, targetTimezoneValue, dateTimeStr);
}

/**
 * URLハッシュを更新
 */
export function updateUrlHash(sourceTimezone, targetTimezone, dateTimeStr) {
  const params = new URLSearchParams();
  params.set('source', sourceTimezone);
  params.set('target', targetTimezone);
  params.set('datetime', dateTimeStr);
  
  window.location.hash = params.toString();
}

/**
 * URLハッシュから変換設定を読み込む
 */
export function loadFromUrlHash(elements, config) {
  if (!window.location.hash) return false;
  
  const params = new URLSearchParams(window.location.hash.substring(1));
  
  const source = params.get('source');
  const target = params.get('target');
  const datetime = params.get('datetime');
  
  if (!source || !target || !datetime) return false;
  
  // 日時が有効な形式かチェック
  const dateTimeParts = datetime.split('T');
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
  
  navigator.clipboard.writeText(url)
    .then(() => {
      alert('URLをクリップボードにコピーしました。');
    })
    .catch(err => {
      console.error('URLのコピーに失敗しました:', err);
      alert('URLのコピーに失敗しました。');
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
  let match = datetimeStr.match(/^(\d{4})-(\d{1,2})-(\d{1,2})\s+(\d{1,2}):(\d{1,2})$/);
  if (match) {
    const [_, year, month, day, hour, minute] = match;
    return {
      date: `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`,
      time: `${hour.padStart(2, '0')}:${minute.padStart(2, '0')}`
    };
  }
  
  // YYYY/MM/DD HH:MM 形式
  match = datetimeStr.match(/^(\d{4})\/(\d{1,2})\/(\d{1,2})\s+(\d{1,2}):(\d{1,2})$/);
  if (match) {
    const [_, year, month, day, hour, minute] = match;
    return {
      date: `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`,
      time: `${hour.padStart(2, '0')}:${minute.padStart(2, '0')}`
    };
  }
  
  // MM/DD/YYYY HH:MM 形式
  match = datetimeStr.match(/^(\d{1,2})\/(\d{1,2})\/(\d{4})\s+(\d{1,2}):(\d{1,2})$/);
  if (match) {
    const [_, month, day, year, hour, minute] = match;
    return {
      date: `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`,
      time: `${hour.padStart(2, '0')}:${minute.padStart(2, '0')}`
    };
  }
  
  // DD.MM.YYYY HH:MM 形式
  match = datetimeStr.match(/^(\d{1,2})\.(\d{1,2})\.(\d{4})\s+(\d{1,2}):(\d{1,2})$/);
  if (match) {
    const [_, day, month, year, hour, minute] = match;
    return {
      date: `${year}-${month.padStart(2, '0')}-${day.padStart(2, '0')}`,
      time: `${hour.padStart(2, '0')}:${minute.padStart(2, '0')}`
    };
  }
  
  // 一致しない場合
  return null;
}

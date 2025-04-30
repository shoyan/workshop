/**
 * UI関連の機能を管理するモジュール
 */
import {
  convertTime,
  copyUrlToClipboard,
  parseDatetimeString,
} from "./converter.js";
import { addToFavorites } from "./favorites.js";
import { addWorldClock } from "./worldclock.js";
import { addParticipant, findOptimalMeetingTimes } from "./meetingplanner.js";

/**
 * タイムゾーンセレクトボックスを初期化
 */
export function initializeTimezoneSelects(elements, timezones) {
  // ユーザーの現在のタイムゾーンを推定
  const userTimezone = Intl.DateTimeFormat().resolvedOptions().timeZone;

  // 変換フォームのセレクトボックス
  populateTimezoneSelect(elements.sourceTimezone, timezones, userTimezone);
  populateTimezoneSelect(elements.targetTimezone, timezones, "UTC");

  // 世界時計追加用のセレクトボックス
  populateTimezoneSelect(elements.addWorldClockSelect, timezones);
}

/**
 * タイムゾーンセレクトボックスにオプションを追加
 */
export function populateTimezoneSelect(
  selectElement,
  timezones,
  selectedValue = null
) {
  // 既存のオプションをクリア
  selectElement.innerHTML = "";

  // タイムゾーンのオプションを追加
  timezones.forEach((tz) => {
    const option = document.createElement("option");
    option.value = tz.value;
    option.textContent = tz.label;
    selectElement.appendChild(option);
  });

  // 選択値があれば設定
  if (selectedValue) {
    selectElement.value = selectedValue;
  }
}

/**
 * テーマの初期化
 */
export function initializeTheme(elements) {
  // 保存されたテーマを取得
  const savedTheme = localStorage.getItem("theme") || "light";

  if (savedTheme === "dark") {
    document.body.classList.add("dark-mode");
    elements.lightModeBtn.classList.remove("active");
    elements.darkModeBtn.classList.add("active");
  } else {
    document.body.classList.remove("dark-mode");
    elements.lightModeBtn.classList.add("active");
    elements.darkModeBtn.classList.remove("active");
  }
}

/**
 * イベントリスナーの設定
 */
export function setupEventListeners(elements, config) {
  // タブ切り替え
  elements.tabBtns.forEach((btn) => {
    btn.addEventListener("click", () => {
      const tabId = btn.dataset.tab;

      // アクティブクラスを切り替え
      elements.tabBtns.forEach((b) => b.classList.remove("active"));
      elements.tabContents.forEach((c) => c.classList.remove("active"));

      btn.classList.add("active");
      document.getElementById(tabId).classList.add("active");
    });
  });

  // テーマ切り替え
  elements.lightModeBtn.addEventListener("click", () => {
    document.body.classList.remove("dark-mode");
    elements.lightModeBtn.classList.add("active");
    elements.darkModeBtn.classList.remove("active");
    localStorage.setItem("theme", "light");
  });

  elements.darkModeBtn.addEventListener("click", () => {
    document.body.classList.add("dark-mode");
    elements.lightModeBtn.classList.remove("active");
    elements.darkModeBtn.classList.add("active");
    localStorage.setItem("theme", "dark");
  });

  // 入力タブ切り替え
  const inputTabBtns = document.querySelectorAll(".input-tab-btn");
  inputTabBtns.forEach((btn) => {
    btn.addEventListener("click", () => {
      const inputTabId = btn.dataset.inputTab;

      // アクティブクラスを切り替え
      inputTabBtns.forEach((b) => b.classList.remove("active"));
      document
        .querySelectorAll(".input-tab-content")
        .forEach((c) => c.classList.remove("active"));

      btn.classList.add("active");
      document.getElementById(inputTabId).classList.add("active");

      // タブ切り替え時にフォームの同期を行う
      if (
        inputTabId === "direct-input" &&
        elements.dateInput.value &&
        elements.timeInput.value
      ) {
        // フォーム入力からシンプル入力へ同期
        elements.datetimeInput.value = `${elements.dateInput.value} ${elements.timeInput.value}`;
      } else if (inputTabId === "form-input" && elements.datetimeInput.value) {
        // シンプル入力からフォーム入力へ同期
        const parsedDateTime = parseDatetimeString(
          elements.datetimeInput.value.trim()
        );
        if (parsedDateTime) {
          elements.dateInput.value = parsedDateTime.date;
          elements.timeInput.value = parsedDateTime.time;
        }
      }
    });
  });

  // 変換ボタン
  elements.convertBtn.addEventListener("click", () => {
    convertTime(elements, config);
  });

  // 日時一括入力フィールドの入力イベント
  if (elements.datetimeInput) {
    elements.datetimeInput.addEventListener("blur", () => {
      if (elements.datetimeInput.value.trim()) {
        const parsedDateTime = parseDatetimeString(
          elements.datetimeInput.value.trim()
        );
        if (parsedDateTime) {
          elements.dateInput.value = parsedDateTime.date;
          elements.timeInput.value = parsedDateTime.time;
        }
      }
    });

    // Enterキー押下時の処理
    elements.datetimeInput.addEventListener("keydown", (e) => {
      if (e.key === "Enter") {
        convertTime(elements, config);
      }
    });
  }

  // フォーム入力（日付・時間）の入力イベント
  if (elements.dateInput && elements.timeInput) {
    // 日付入力のblurイベント
    elements.dateInput.addEventListener("blur", () => {
      syncFormToDateTime(elements);
    });

    // 時間入力のblurイベント
    elements.timeInput.addEventListener("blur", () => {
      syncFormToDateTime(elements);
    });

    // Enterキー押下時の処理
    elements.dateInput.addEventListener("keydown", (e) => {
      if (e.key === "Enter") {
        convertTime(elements, config);
      }
    });

    elements.timeInput.addEventListener("keydown", (e) => {
      if (e.key === "Enter") {
        convertTime(elements, config);
      }
    });
  }

  // お気に入り追加ボタン
  elements.addFavoriteBtn.addEventListener("click", () => {
    addToFavorites(elements, config);
  });

  // URLコピーボタン
  elements.copyUrlBtn.addEventListener("click", () => {
    copyUrlToClipboard();
  });

  // 世界時計追加ボタン
  elements.addClockBtn.addEventListener("click", () => {
    addWorldClock(elements, config);
  });

  // 参加者追加ボタン
  elements.addParticipantBtn.addEventListener("click", () => {
    addParticipant(elements, config);
  });

  // 最適時間探索ボタン
  elements.findTimesBtn.addEventListener("click", () => {
    findOptimalMeetingTimes(elements, config);
  });
}

/**
 * フォーム入力の値をシンプル入力フィールドに同期する関数
 */
function syncFormToDateTime(elements) {
  if (elements.dateInput.value && elements.timeInput.value) {
    // 日付と時間の形式をチェック
    const dateRegex = /^\d{4}-\d{2}-\d{2}$/;
    const timeRegex = /^([01][0-9]|2[0-3]):([0-5][0-9])$/;

    // 有効な形式の場合のみ同期する
    if (
      dateRegex.test(elements.dateInput.value) &&
      timeRegex.test(elements.timeInput.value)
    ) {
      elements.datetimeInput.value = `${elements.dateInput.value} ${elements.timeInput.value}`;
    }
  }
}

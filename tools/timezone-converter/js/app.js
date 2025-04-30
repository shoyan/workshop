// メインのアプリケーション初期化
import { initializeConfig } from "./config.js";
import {
  initializeTimezoneSelects,
  initializeTheme,
  setupEventListeners,
} from "./ui.js";
import { loadFromUrlHash } from "./converter.js";
import { renderFavorites } from "./favorites.js";
import { renderWorldClocks, updateAllClocks } from "./worldclock.js";

document.addEventListener("DOMContentLoaded", function () {
  // DOM要素の取得
  const elements = getElements();

  // 設定の初期化
  const config = initializeConfig();

  // 初期化
  initializeApp(elements, config);

  /**
   * DOM要素の取得
   */
  function getElements() {
    return {
      // タブ切り替え
      tabBtns: document.querySelectorAll(".tab-btn"),
      tabContents: document.querySelectorAll(".tab-content"),

      // テーマ切り替え
      lightModeBtn: document.getElementById("light-mode"),
      darkModeBtn: document.getElementById("dark-mode"),

      // 変換フォーム
      dateInput: document.getElementById("date-input"),
      timeInput: document.getElementById("time-input"),
      datetimeInput: document.getElementById("datetime-input"),
      sourceTimezone: document.getElementById("source-timezone"),
      targetTimezone: document.getElementById("target-timezone"),
      convertBtn: document.getElementById("convert-btn"),
      resultContainer: document.getElementById("result"),
      resultContent: document.getElementById("result-content"),

      // お気に入り
      addFavoriteBtn: document.getElementById("add-favorite"),
      favoritesContainer: document.getElementById("favorites-container"),
      copyUrlBtn: document.getElementById("copy-url"),

      // 世界時計
      worldClocks: document.getElementById("world-clocks"),
      addWorldClockSelect: document.getElementById("add-world-clock"),
      addClockBtn: document.getElementById("add-clock-btn"),

      // ミーティングプランナー
      participantsList: document.getElementById("participants-list"),
      addParticipantBtn: document.getElementById("add-participant"),
      meetingDate: document.getElementById("meeting-date"),
      findTimesBtn: document.getElementById("find-times"),
      meetingResults: document.getElementById("meeting-results"),
      timeSuggestions: document.getElementById("time-suggestions"),
      timeMatrix: document.getElementById("time-matrix"),
    };
  }

  /**
   * アプリケーションの初期化
   */
  function initializeApp(elements, config) {
    // 現在の日付と時間をセット
    setCurrentDateTime(elements);

    // タイムゾーンセレクトボックスを初期化
    initializeTimezoneSelects(elements, config.timezones);

    // テーマの初期化
    initializeTheme(elements);

    // お気に入りの表示
    renderFavorites(elements, config);

    // 世界時計の表示
    renderWorldClocks(elements, config);

    // クロックの自動更新（1分ごと）
    setInterval(() => updateAllClocks(elements, config), 60000);

    // ミーティングプランナーの初期化
    initializeMeetingPlanner(elements, config);

    // イベントリスナーの設定
    setupEventListeners(elements, config);

    // URLハッシュがあれば読み込む
    loadFromUrlHash(elements, config);
  }

  /**
   * 現在の日付と時間をセット（フォームが空の場合のみ）
   */
  function setCurrentDateTime(elements) {
    // フォームにすでに値が入力されている場合は何もしない
    if (elements.dateInput.value && elements.timeInput.value) {
      return;
    }

    const now = new Date();
    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, "0");
    const day = String(now.getDate()).padStart(2, "0");
    const hours = String(now.getHours()).padStart(2, "0");
    const minutes = String(now.getMinutes()).padStart(2, "0");

    // テキストフィールドに日付と時間をセット
    elements.dateInput.value = `${year}-${month}-${day}`;
    elements.timeInput.value = `${hours}:${minutes}`;

    // シンプル入力フィールドにも日時をセット
    if (!elements.datetimeInput.value) {
      elements.datetimeInput.value = `${year}-${month}-${day} ${hours}:${minutes}`;
    }

    // ミーティングプランナーの日付も設定
    if (!elements.meetingDate.value) {
      elements.meetingDate.value = `${year}-${month}-${day}`;
    }
  }

  /**
   * ミーティングプランナーの初期化
   */
  function initializeMeetingPlanner(elements, config) {
    // 参加者のタイムゾーンセレクトを設定
    const participantTimezonesSelects = document.querySelectorAll(
      ".participant-timezone"
    );
    participantTimezonesSelects.forEach((select) => {
      populateTimezoneSelect(select, config.timezones);
    });

    // 参加者削除ボタン
    document.querySelectorAll(".remove-participant").forEach((btn) => {
      btn.addEventListener("click", function () {
        this.closest(".participant").remove();
      });
    });
  }

  /**
   * タイムゾーンセレクトボックスにオプションを追加
   */
  function populateTimezoneSelect(
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
});

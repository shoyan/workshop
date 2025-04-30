/**
 * UI関連の機能を管理するモジュール
 */
import { convertTime, copyUrlToClipboard } from './converter.js';
import { addToFavorites } from './favorites.js';
import { addWorldClock } from './worldclock.js';
import { addParticipant, findOptimalMeetingTimes } from './meetingplanner.js';

/**
 * タイムゾーンセレクトボックスを初期化
 */
export function initializeTimezoneSelects(elements, timezones) {
  // ユーザーの現在のタイムゾーンを推定
  const userTimezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
  
  // 変換フォームのセレクトボックス
  populateTimezoneSelect(elements.sourceTimezone, timezones, userTimezone);
  populateTimezoneSelect(elements.targetTimezone, timezones, 'America/New_York');
  
  // 世界時計追加用のセレクトボックス
  populateTimezoneSelect(elements.addWorldClockSelect, timezones);
}

/**
 * タイムゾーンセレクトボックスにオプションを追加
 */
export function populateTimezoneSelect(selectElement, timezones, selectedValue = null) {
  // 既存のオプションをクリア
  selectElement.innerHTML = '';
  
  // タイムゾーンのオプションを追加
  timezones.forEach(tz => {
    const option = document.createElement('option');
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
  const savedTheme = localStorage.getItem('theme') || 'light';
  
  if (savedTheme === 'dark') {
    document.body.classList.add('dark-mode');
    elements.lightModeBtn.classList.remove('active');
    elements.darkModeBtn.classList.add('active');
  } else {
    document.body.classList.remove('dark-mode');
    elements.lightModeBtn.classList.add('active');
    elements.darkModeBtn.classList.remove('active');
  }
}

/**
 * イベントリスナーの設定
 */
export function setupEventListeners(elements, config) {
  // タブ切り替え
  elements.tabBtns.forEach(btn => {
    btn.addEventListener('click', () => {
      const tabId = btn.dataset.tab;
      
      // アクティブクラスを切り替え
      elements.tabBtns.forEach(b => b.classList.remove('active'));
      elements.tabContents.forEach(c => c.classList.remove('active'));
      
      btn.classList.add('active');
      document.getElementById(tabId).classList.add('active');
    });
  });
  
  // テーマ切り替え
  elements.lightModeBtn.addEventListener('click', () => {
    document.body.classList.remove('dark-mode');
    elements.lightModeBtn.classList.add('active');
    elements.darkModeBtn.classList.remove('active');
    localStorage.setItem('theme', 'light');
  });
  
  elements.darkModeBtn.addEventListener('click', () => {
    document.body.classList.add('dark-mode');
    elements.lightModeBtn.classList.remove('active');
    elements.darkModeBtn.classList.add('active');
    localStorage.setItem('theme', 'dark');
  });
  
  // 変換ボタン
  elements.convertBtn.addEventListener('click', () => {
    convertTime(elements, config);
  });
  
  // お気に入り追加ボタン
  elements.addFavoriteBtn.addEventListener('click', () => {
    addToFavorites(elements, config);
  });
  
  // URLコピーボタン
  elements.copyUrlBtn.addEventListener('click', () => {
    copyUrlToClipboard();
  });
  
  // 世界時計追加ボタン
  elements.addClockBtn.addEventListener('click', () => {
    addWorldClock(elements, config);
  });
  
  // 参加者追加ボタン
  elements.addParticipantBtn.addEventListener('click', () => {
    addParticipant(elements, config);
  });
  
  // 最適時間探索ボタン
  elements.findTimesBtn.addEventListener('click', () => {
    findOptimalMeetingTimes(elements, config);
  });
}

/**
 * タイムゾーン変換の機能を管理するモジュール
 */

/**
 * 時間変換を実行
 */
export function convertTime(elements, config) {
  // 入力チェック
  if (!elements.dateInput.value || !elements.timeInput.value) {
    alert('日付と時間を入力してください。');
    return;
  }
  
  const sourceTimezoneValue = elements.sourceTimezone.value;
  const targetTimezoneValue = elements.targetTimezone.value;
  
  // 入力された日時を取得
  const inputDate = elements.dateInput.value;
  const inputTime = elements.timeInput.value;
  
  // 日時文字列を作成（ISO 8601形式）
  const dateTimeStr = `${inputDate}T${inputTime}:00`;
  
  // 日時オブジェクトを作成（入力はローカルタイムとして解釈）
  const date = new Date(dateTimeStr);
  
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
  
  const date = dateTimeParts[0];
  const time = dateTimeParts[1].substring(0, 5); // HH:MM の部分だけ
  
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

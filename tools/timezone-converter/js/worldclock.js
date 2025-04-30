/**
 * 世界時計の機能を管理するモジュール
 */

/**
 * 世界時計を表示
 */
export function renderWorldClocks(elements, config) {
  elements.worldClocks.innerHTML = '';
  
  config.displayedClocks.forEach(timezone => {
    const clockItem = createClockElement(timezone, elements, config);
    elements.worldClocks.appendChild(clockItem);
  });
  
  // 最初の更新
  updateAllClocks(elements, config);
}

/**
 * 単一の時計要素を作成
 */
export function createClockElement(timezone, elements, config) {
  const clockItem = document.createElement('div');
  clockItem.className = 'clock-item';
  clockItem.dataset.timezone = timezone;
  
  const clockInfo = document.createElement('div');
  clockInfo.className = 'clock-info';
  
  const city = document.createElement('h4');
  city.textContent = config.cityNames[timezone];
  
  const time = document.createElement('div');
  time.className = 'clock-time';
  
  const date = document.createElement('div');
  date.className = 'clock-date';
  
  clockInfo.appendChild(city);
  clockInfo.appendChild(time);
  clockInfo.appendChild(date);
  
  const removeBtn = document.createElement('button');
  removeBtn.className = 'remove-clock';
  removeBtn.innerHTML = '<i class="fas fa-times"></i>';
  removeBtn.addEventListener('click', () => {
    const index = config.displayedClocks.indexOf(timezone);
    if (index !== -1) {
      config.displayedClocks.splice(index, 1);
      localStorage.setItem('displayed-clocks', JSON.stringify(config.displayedClocks));
      clockItem.remove();
    }
  });
  
  clockItem.appendChild(clockInfo);
  clockItem.appendChild(removeBtn);
  
  return clockItem;
}

/**
 * すべての時計を更新
 */
export function updateAllClocks(elements, config) {
  const clockItems = document.querySelectorAll('.clock-item');
  
  clockItems.forEach(item => {
    const timezone = item.dataset.timezone;
    const timeElement = item.querySelector('.clock-time');
    const dateElement = item.querySelector('.clock-date');
    
    const now = new Date();
    const options = {
      timeZone: timezone,
      hour: '2-digit',
      minute: '2-digit',
      hour12: false
    };
    
    const dateOptions = {
      timeZone: timezone,
      weekday: 'short',
      year: 'numeric',
      month: 'short',
      day: 'numeric'
    };
    
    timeElement.textContent = new Intl.DateTimeFormat('ja-JP', options).format(now);
    dateElement.textContent = new Intl.DateTimeFormat('ja-JP', dateOptions).format(now);
    
    // 昼/夜のスタイルを適用
    const hour = parseInt(timeElement.textContent.split(':')[0]);
    if (hour >= 6 && hour < 18) {
      item.classList.add('daytime');
      item.classList.remove('nighttime');
    } else {
      item.classList.add('nighttime');
      item.classList.remove('daytime');
    }
  });
}

/**
 * 世界時計を追加
 */
export function addWorldClock(elements, config) {
  const selectedTimezone = elements.addWorldClockSelect.value;
  
  // 既に表示されているかチェック
  if (config.displayedClocks.includes(selectedTimezone)) {
    alert('この都市の時計は既に表示されています。');
    return;
  }
  
  // 追加
  config.displayedClocks.push(selectedTimezone);
  localStorage.setItem('displayed-clocks', JSON.stringify(config.displayedClocks));
  
  // 新しい時計要素を作成して追加
  const clockItem = createClockElement(selectedTimezone, elements, config);
  elements.worldClocks.appendChild(clockItem);
  
  // 時計を更新
  updateAllClocks(elements, config);
}

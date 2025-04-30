/**
 * お気に入り機能を管理するモジュール
 */
import { convertTime } from './converter.js';

/**
 * お気に入りを表示
 */
export function renderFavorites(elements, config) {
  elements.favoritesContainer.innerHTML = '';
  
  if (config.favorites.length === 0) {
    const emptyMessage = document.createElement('p');
    emptyMessage.textContent = 'お気に入りはまだありません';
    emptyMessage.className = 'empty-message';
    elements.favoritesContainer.appendChild(emptyMessage);
    return;
  }
  
  config.favorites.forEach((fav, index) => {
    const favoriteItem = document.createElement('div');
    favoriteItem.className = 'favorite-item';
    
    const favoriteInfo = document.createElement('div');
    favoriteInfo.className = 'favorite-info';
    
    const favTitle = document.createElement('div');
    favTitle.textContent = `${config.cityNames[fav.source]} → ${config.cityNames[fav.target]}`;
    favTitle.className = 'fav-title';
    
    favoriteInfo.appendChild(favTitle);
    favoriteItem.appendChild(favoriteInfo);
    
    const actionButtons = document.createElement('div');
    
    const useButton = document.createElement('button');
    useButton.innerHTML = '<i class="fas fa-sync-alt"></i>';
    useButton.title = '変換に使用';
    useButton.addEventListener('click', () => {
      elements.sourceTimezone.value = fav.source;
      elements.targetTimezone.value = fav.target;
      convertTime(elements, config);
    });
    
    const deleteButton = document.createElement('button');
    deleteButton.innerHTML = '<i class="fas fa-trash"></i>';
    deleteButton.title = '削除';
    deleteButton.addEventListener('click', () => {
      config.favorites.splice(index, 1);
      localStorage.setItem('timezone-favorites', JSON.stringify(config.favorites));
      renderFavorites(elements, config);
    });
    
    actionButtons.appendChild(useButton);
    actionButtons.appendChild(deleteButton);
    favoriteItem.appendChild(actionButtons);
    
    elements.favoritesContainer.appendChild(favoriteItem);
  });
}

/**
 * お気に入りに追加
 */
export function addToFavorites(elements, config) {
  const source = elements.sourceTimezone.value;
  const target = elements.targetTimezone.value;
  
  // 既に同じ組み合わせがあるかチェック
  const exists = config.favorites.some(f => f.source === source && f.target === target);
  
  if (exists) {
    alert('この組み合わせは既にお気に入りに登録されています。');
    return;
  }
  
  config.favorites.push({ source, target });
  localStorage.setItem('timezone-favorites', JSON.stringify(config.favorites));
  
  renderFavorites(elements, config);
  
  alert('お気に入りに追加しました。');
}

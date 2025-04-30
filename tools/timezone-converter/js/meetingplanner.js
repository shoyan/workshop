/**
 * ミーティングプランナーの機能を管理するモジュール
 */

/**
 * 参加者を追加
 */
export function addParticipant(elements, config) {
  // 新しい参加者行を作成
  const participantRow = document.createElement('div');
  participantRow.className = 'participant';
  
  // 参加者名入力
  const nameInput = document.createElement('input');
  nameInput.type = 'text';
  nameInput.placeholder = '参加者名';
  nameInput.className = 'participant-name';
  
  // タイムゾーン選択
  const timezoneSelect = document.createElement('select');
  timezoneSelect.className = 'participant-timezone';
  
  // タイムゾーンオプションを追加
  config.timezones.forEach(tz => {
    const option = document.createElement('option');
    option.value = tz.value;
    option.textContent = tz.label;
    timezoneSelect.appendChild(option);
  });
  
  // 削除ボタン
  const removeBtn = document.createElement('button');
  removeBtn.className = 'remove-participant secondary-btn';
  removeBtn.innerHTML = '<i class="fas fa-trash"></i>';
  removeBtn.addEventListener('click', function() {
    participantRow.remove();
  });
  
  // 要素を行に追加
  participantRow.appendChild(nameInput);
  participantRow.appendChild(timezoneSelect);
  participantRow.appendChild(removeBtn);
  
  // 参加者リストに追加
  elements.participantsList.appendChild(participantRow);
}

/**
 * 最適なミーティング時間を探索
 */
export function findOptimalMeetingTimes(elements, config) {
  // 参加者とそのタイムゾーンを取得
  const participants = [];
  
  document.querySelectorAll('.participant').forEach(p => {
    const nameInput = p.querySelector('.participant-name');
    const timezoneSelect = p.querySelector('.participant-timezone');
    
    if (nameInput.value.trim()) {
      participants.push({
        name: nameInput.value.trim(),
        timezone: timezoneSelect.value
      });
    }
  });
  
  // 参加者が2人未満の場合はアラート
  if (participants.length < 2) {
    alert('ミーティングを計画するには少なくとも2人の参加者が必要です。');
    return;
  }
  
  // 選択された日付
  const meetingDate = elements.meetingDate.value;
  if (!meetingDate) {
    alert('ミーティングの日付を選択してください。');
    return;
  }
  
  // 1時間ごとの時間スロットを評価（0-23時）
  const timeSlots = [];
  for (let hour = 0; hour < 24; hour++) {
    const slot = {
      hour,
      formattedHour: `${hour.toString().padStart(2, '0')}:00`,
      participants: {},
      totalScore: 0
    };
    
    // 各参加者のローカル時間とスコアを計算
    participants.forEach(participant => {
      const { localHour, localDate } = convertToLocalTime(meetingDate, hour, participant.timezone);
      const score = calculateTimeScore(localHour, config.scoring);
      
      slot.participants[participant.name] = {
        localTime: `${localHour.toString().padStart(2, '0')}:00`,
        localDate,
        score,
        status: getTimeStatus(localHour, score)
      };
      
      slot.totalScore += score;
    });
    
    timeSlots.push(slot);
  }
  
  // スコアで並べ替え（降順）
  timeSlots.sort((a, b) => b.totalScore - a.totalScore);
  
  // 結果表示
  showMeetingResults(elements, timeSlots, participants);
}

/**
 * UTCの時間を特定のタイムゾーンのローカル時間に変換
 */
function convertToLocalTime(dateStr, utcHour, timezone) {
  // 日付文字列とUTC時間から日時を作成
  const date = new Date(`${dateStr}T${utcHour.toString().padStart(2, '0')}:00:00Z`);
  
  // 指定されたタイムゾーンでの時間を取得
  const options = {
    timeZone: timezone,
    hour: 'numeric',
    hour12: false
  };
  
  const dateOptions = {
    timeZone: timezone,
    year: 'numeric',
    month: '2-digit',
    day: '2-digit'
  };
  
  const localTime = new Intl.DateTimeFormat('ja-JP', options).format(date);
  const localDate = new Intl.DateTimeFormat('ja-JP', dateOptions).format(date);
  
  return {
    localHour: parseInt(localTime),
    localDate
  };
}

/**
 * 時間帯ごとのスコアを計算
 */
function calculateTimeScore(hour, scoring) {
  // 9-17時: 良い時間帯 (スコア: 2)
  if (hour >= scoring.goodHoursStart && hour < scoring.goodHoursEnd) {
    return scoring.goodScore;
  }
  
  // 7-9時、17-21時: 許容できる時間帯 (スコア: 1)
  if ((hour >= scoring.okHoursStartMorning && hour < scoring.okHoursEndMorning) ||
      (hour >= scoring.okHoursStartEvening && hour < scoring.okHoursEndEvening)) {
    return scoring.okScore;
  }
  
  // 21-7時: 悪い時間帯 (スコア: -1)
  return scoring.badScore;
}

/**
 * 時間帯の状態を取得
 */
function getTimeStatus(hour, score) {
  if (score === 2) return 'good';
  if (score === 1) return 'ok';
  if (score === -1 && (hour >= 21 || hour < 7)) return 'sleeping';
  return 'bad';
}

/**
 * ミーティング結果を表示
 */
function showMeetingResults(elements, timeSlots, participants) {
  elements.meetingResults.classList.remove('hidden');
  
  // おすすめ時間を表示
  elements.timeSuggestions.innerHTML = '';
  
  // 上位3つのスロットを表示
  const topSlots = timeSlots.slice(0, 3);
  
  topSlots.forEach((slot, index) => {
    const suggestion = document.createElement('div');
    suggestion.className = 'time-suggestion';
    
    const heading = document.createElement('h4');
    heading.textContent = `おすすめ ${index + 1}: UTC ${slot.formattedHour}`;
    
    const participantsList = document.createElement('ul');
    
    Object.keys(slot.participants).forEach(name => {
      const participant = slot.participants[name];
      const item = document.createElement('li');
      
      let statusIcon = '';
      if (participant.status === 'good') {
        statusIcon = '🟢';
      } else if (participant.status === 'ok') {
        statusIcon = '🟡';
      } else if (participant.status === 'sleeping') {
        statusIcon = '😴';
      } else {
        statusIcon = '🔴';
      }
      
      item.textContent = `${name}: ${participant.localTime} (${participant.localDate}) ${statusIcon}`;
      participantsList.appendChild(item);
    });
    
    suggestion.appendChild(heading);
    suggestion.appendChild(participantsList);
    elements.timeSuggestions.appendChild(suggestion);
  });
  
  // 時間マトリックスを表示
  elements.timeMatrix.innerHTML = '';
  
  const table = document.createElement('table');
  
  // ヘッダー行
  const headerRow = document.createElement('tr');
  const timeHeader = document.createElement('th');
  timeHeader.textContent = 'UTC時間';
  headerRow.appendChild(timeHeader);
  
  participants.forEach(p => {
    const th = document.createElement('th');
    th.textContent = p.name;
    headerRow.appendChild(th);
  });
  
  const scoreHeader = document.createElement('th');
  scoreHeader.textContent = '合計スコア';
  headerRow.appendChild(scoreHeader);
  
  table.appendChild(headerRow);
  
  // 各時間のデータ行
  timeSlots.forEach(slot => {
    const row = document.createElement('tr');
    
    const timeCell = document.createElement('td');
    timeCell.textContent = slot.formattedHour;
    row.appendChild(timeCell);
    
    participants.forEach(p => {
      const participantData = slot.participants[p.name];
      const cell = document.createElement('td');
      cell.className = `time-cell ${participantData.status}`;
      cell.textContent = participantData.localTime;
      row.appendChild(cell);
    });
    
    const scoreCell = document.createElement('td');
    scoreCell.textContent = slot.totalScore;
    row.appendChild(scoreCell);
    
    table.appendChild(row);
  });
  
  elements.timeMatrix.appendChild(table);
}

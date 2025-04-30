/**
 * アプリケーションの設定ファイル
 * タイムゾーンのリストやデフォルト値などを管理
 */

/**
 * 設定の初期化
 */
export function initializeConfig() {
  return {
    // タイムゾーンリスト
    timezones: [
      { value: 'UTC', label: 'UTC (GMT+0)' },
      { value: 'Asia/Tokyo', label: '東京 (GMT+9)' },
      { value: 'Asia/Seoul', label: 'ソウル (GMT+9)' },
      { value: 'Asia/Shanghai', label: '上海 (GMT+8)' },
      { value: 'Asia/Singapore', label: 'シンガポール (GMT+8)' },
      { value: 'Australia/Sydney', label: 'シドニー (GMT+10/+11)' },
      { value: 'Europe/London', label: 'ロンドン (GMT+0/+1)' },
      { value: 'Europe/Paris', label: 'パリ (GMT+1/+2)' },
      { value: 'Europe/Berlin', label: 'ベルリン (GMT+1/+2)' },
      { value: 'Europe/Moscow', label: 'モスクワ (GMT+3)' },
      { value: 'America/New_York', label: 'ニューヨーク (GMT-5/-4)' },
      { value: 'America/Los_Angeles', label: 'ロサンゼルス (GMT-8/-7)' },
      { value: 'America/Chicago', label: 'シカゴ (GMT-6/-5)' },
      { value: 'America/Toronto', label: 'トロント (GMT-5/-4)' },
      { value: 'America/Sao_Paulo', label: 'サンパウロ (GMT-3/-2)' },
      { value: 'Pacific/Honolulu', label: 'ホノルル (GMT-10)' },
      { value: 'Asia/Dubai', label: 'ドバイ (GMT+4)' },
      { value: 'Asia/Kolkata', label: 'ムンバイ (GMT+5:30)' }
    ],
    
    // 都市表示名
    cityNames: {
      'UTC': 'UTC',
      'Asia/Tokyo': '東京',
      'Asia/Seoul': 'ソウル',
      'Asia/Shanghai': '上海',
      'Asia/Singapore': 'シンガポール',
      'Australia/Sydney': 'シドニー',
      'Europe/London': 'ロンドン',
      'Europe/Paris': 'パリ',
      'Europe/Berlin': 'ベルリン',
      'Europe/Moscow': 'モスクワ',
      'America/New_York': 'ニューヨーク',
      'America/Los_Angeles': 'ロサンゼルス',
      'America/Chicago': 'シカゴ',
      'America/Toronto': 'トロント',
      'America/Sao_Paulo': 'サンパウロ',
      'Pacific/Honolulu': 'ホノルル',
      'Asia/Dubai': 'ドバイ',
      'Asia/Kolkata': 'ムンバイ'
    },
    
    // お気に入りを保存するための配列
    favorites: JSON.parse(localStorage.getItem('timezone-favorites')) || [],
    
    // 世界時計で表示する都市
    displayedClocks: JSON.parse(localStorage.getItem('displayed-clocks')) || ['Asia/Tokyo', 'America/New_York', 'Europe/London'],
    
    // スコアリング設定（ミーティングプランナー用）
    scoring: {
      goodHoursStart: 9,
      goodHoursEnd: 17,
      okHoursStartMorning: 7,
      okHoursEndMorning: 9,
      okHoursStartEvening: 17,
      okHoursEndEvening: 21,
      goodScore: 2,
      okScore: 1,
      badScore: -1
    }
  };
}

// 変数を宣言
// htmlタグの要素を取得する
const para = document.querySelector('p');

// paraが実行されたらupdateName関数を実行する
para.addEventListener('click', updateName);

// 関数
function updateName() {
  // 変数を宣言
  // プロンプトを表示してデータを入力してもらう関数を実行する
  let name = prompt('名前を入力して下さい！！！！');
  // pタグのテキストを書き換える
  para.textContent = 'Player 1: ' + name;
}
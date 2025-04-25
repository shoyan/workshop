let currentJson = ""; // JSONを保持する変数

document.getElementById("formatButton").addEventListener("click", function () {
  const json = getValidJsonInput();
  if (!json) return;

  const outputElement = document.getElementById("jsonOutput");
  const formatted = JSON.stringify(json, null, 2);
  outputElement.textContent = formatted;
  document.getElementById("errorMessage").textContent = "";
  Prism.highlightElement(outputElement); // Prismで色付け
});

// コンパクト表示
document.getElementById("compactButton").addEventListener("click", () => {
  const json = getValidJsonInput();
  if (!json) return;

  const compact = JSON.stringify(json);
  document.getElementById("jsonOutput").innerText = compact;
  document.getElementById("errorMessage").textContent = "";
});

// マークダウンテーブルに変換
document
  .getElementById("markdownButton")
  .addEventListener("click", function () {
    const outputElement = document.getElementById("jsonOutput");
    const errorMessageElement = document.getElementById("errorMessage");

    const json = getValidJsonInput();
    if (!json) return;

    const markdownTable = jsonToMarkdown(json);
    outputElement.textContent = markdownTable; // マークダウン形式のテーブルを表示
    errorMessageElement.textContent = ""; // エラーメッセージをクリア
  });

// SQLのINSERT文に変換
document.getElementById("sqlButton").addEventListener("click", function () {
  const outputElement = document.getElementById("jsonOutput");
  const errorMessageElement = document.getElementById("errorMessage");

  const json = getValidJsonInput();
  if (!json) return;

  const sqlInsert = jsonToSQLInsert(json, "your_table_name"); // テーブル名は適宜変更
  outputElement.textContent = sqlInsert; // SQL文を表示
  errorMessageElement.textContent = ""; // エラーメッセージをクリア
});

// JSONをマークダウン形式のテーブルに変換する関数
function jsonToMarkdown(json) {
  const keys = Object.keys(json);
  const values = Object.values(json);

  // キーを一行目に、値を二行目に並べる
  let markdown = "| " + keys.join(" | ") + " |\n";
  markdown += "| " + keys.map(() => "---").join(" | ") + " |\n";

  // 値がオブジェクトや配列の場合、文字列に変換
  let rowValues = values.map((value) => {
    if (typeof value === "object") {
      return JSON.stringify(value); // オブジェクトは文字列に変換
    }
    return value;
  });

  markdown += "| " + rowValues.join(" | ") + " |\n";

  return markdown;
}

// JSONをSQLのINSERT文に変換する関数
function jsonToSQLInsert(json, tableName) {
  const keys = Object.keys(json);
  const values = Object.values(json);

  // 値がオブジェクトの場合、JSON文字列として扱う
  const formattedValues = values.map((value) => {
    if (typeof value === "object") {
      return `'${JSON.stringify(value)}'`; // オブジェクトをJSON文字列に変換して囲む
    }
    if (typeof value === "string") {
      return `'${value.replace(/'/g, "''")}'`; // シングルクォートをエスケープ
    }
    return value;
  });

  // SQLのINSERT文を組み立て
  const sql = `INSERT INTO ${tableName} (${keys.join(
    ", "
  )}) VALUES (${formattedValues.join(", ")});`;
  return sql;
}

// コピー機能
document.getElementById("copyButton").addEventListener("click", () => {
  const outputText = document.getElementById("jsonOutput").innerText;

  navigator.clipboard
    .writeText(outputText)
    .then(() => {
      const btn = document.getElementById("copyButton");
      btn.innerHTML = "✅ コピーしました";
      setTimeout(() => {
        btn.innerHTML = `
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
             class="bi bi-clipboard me-1" viewBox="0 0 16 16">
          <path d="M10 1.5v1h2.5A1.5 1.5 0 0 1 14 4v9.5A1.5 1.5 0 0 1 12.5 15h-9A1.5 1.5 0 0 1 2 13.5V4A1.5 1.5 0 0 1 3.5 2.5H6v-1h4zM6 0h4a.5.5 0 0 1 .5.5V2H5.5V.5A.5.5 0 0 1 6 0z"/>
        </svg>
        コピー`;
      }, 1500);
    })
    .catch((err) => {
      alert("コピーに失敗しました: " + err);
    });
});

// ページ読み込み時にセッションストレージから復元
window.addEventListener("DOMContentLoaded", () => {
  const savedJson = sessionStorage.getItem("jsonInput");
  if (savedJson) {
    document.getElementById("jsonInput").value = savedJson;
  }
});

// JSON入力が変化するたびにセッションストレージに保存
document.getElementById("jsonInput").addEventListener("input", () => {
  const jsonText = document.getElementById("jsonInput").value;
  sessionStorage.setItem("jsonInput", jsonText);
});

function getValidJsonInput() {
  const input = document.getElementById("jsonInput").value;
  try {
    return JSON.parse(input);
  } catch (e) {
    document.getElementById("errorMessage").textContent =
      "❌ JSONの形式が正しくありません。";
    return null;
  }
}

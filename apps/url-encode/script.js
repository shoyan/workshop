// URL Encoder/Decoder Tool - JavaScript functionality

document.addEventListener('DOMContentLoaded', function() {
    // エンコード関連の要素
    const encodeInput = document.getElementById('encodeInput');
    const encodeOutput = document.getElementById('encodeOutput');
    const encodeBtn = document.getElementById('encodeBtn');
    const encodeCopyBtn = document.getElementById('encodeCopyBtn');
    const encodeClearBtn = document.getElementById('encodeClearBtn');
    
    // デコード関連の要素
    const decodeInput = document.getElementById('decodeInput');
    const decodeOutput = document.getElementById('decodeOutput');
    const decodeBtn = document.getElementById('decodeBtn');
    const decodeCopyBtn = document.getElementById('decodeCopyBtn');
    const decodeClearBtn = document.getElementById('decodeClearBtn');
    
    // 一括処理関連の要素
    const batchInput = document.getElementById('batchInput');
    const batchOutput = document.getElementById('batchOutput');
    const batchEncodeBtn = document.getElementById('batchEncodeBtn');
    const batchDecodeBtn = document.getElementById('batchDecodeBtn');
    const batchCopyBtn = document.getElementById('batchCopyBtn');
    const batchClearBtn = document.getElementById('batchClearBtn');
    
    // エンコード処理
    function encodeURL(text) {
        try {
            return encodeURIComponent(text);
        } catch (error) {
            console.error('エンコードエラー:', error);
            return 'エラー: 無効な入力です';
        }
    }
    
    // デコード処理
    function decodeURL(text) {
        try {
            return decodeURIComponent(text);
        } catch (error) {
            console.error('デコードエラー:', error);
            return 'エラー: 無効なエンコード形式です';
        }
    }
    
    // クリップボードにコピー機能
    function copyToClipboard(text, element) {
        navigator.clipboard.writeText(text)
            .then(() => {
                // コピー成功時のフィードバック
                element.classList.add('copy-success');
                setTimeout(() => {
                    element.classList.remove('copy-success');
                }, 1000);
            })
            .catch(err => {
                console.error('クリップボードへのコピーに失敗しました:', err);
                alert('クリップボードへのコピーに失敗しました');
            });
    }
    
    // リアルタイムエンコード
    encodeInput.addEventListener('input', function() {
        encodeOutput.value = encodeURL(this.value);
    });
    
    // リアルタイムデコード
    decodeInput.addEventListener('input', function() {
        decodeOutput.value = decodeURL(this.value);
    });
    
    // エンコードボタン
    encodeBtn.addEventListener('click', function() {
        encodeOutput.value = encodeURL(encodeInput.value);
    });
    
    // デコードボタン
    decodeBtn.addEventListener('click', function() {
        decodeOutput.value = decodeURL(decodeInput.value);
    });
    
    // エンコード結果コピー
    encodeCopyBtn.addEventListener('click', function() {
        copyToClipboard(encodeOutput.value, encodeOutput);
    });
    
    // デコード結果コピー
    decodeCopyBtn.addEventListener('click', function() {
        copyToClipboard(decodeOutput.value, decodeOutput);
    });
    
    // エンコードクリア
    encodeClearBtn.addEventListener('click', function() {
        encodeInput.value = '';
        encodeOutput.value = '';
    });
    
    // デコードクリア
    decodeClearBtn.addEventListener('click', function() {
        decodeInput.value = '';
        decodeOutput.value = '';
    });
    
    // 一括エンコード
    batchEncodeBtn.addEventListener('click', function() {
        const lines = batchInput.value.split('\n');
        const encodedLines = lines.map(line => encodeURL(line));
        batchOutput.value = encodedLines.join('\n');
    });
    
    // 一括デコード
    batchDecodeBtn.addEventListener('click', function() {
        const lines = batchInput.value.split('\n');
        const decodedLines = lines.map(line => decodeURL(line));
        batchOutput.value = decodedLines.join('\n');
    });
    
    // 一括処理結果コピー
    batchCopyBtn.addEventListener('click', function() {
        copyToClipboard(batchOutput.value, batchOutput);
    });
    
    // 一括処理クリア
    batchClearBtn.addEventListener('click', function() {
        batchInput.value = '';
        batchOutput.value = '';
    });
});

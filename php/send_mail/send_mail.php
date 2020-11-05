<?php
mb_language("Japanese");
mb_internal_encoding("UTF-8");
if (mb_send_mail(
    "TEST_TO_ADDR@domain.com",  // 送信先メールアドレス
    "件名",
    "本文",
    "From :".mb_encode_mimeheader("テスト送信元")."<TEST_FROM_ADDR@domain.com>"
))
{
    echo "成功\n";
}
else {
    echo "失敗\n";
}

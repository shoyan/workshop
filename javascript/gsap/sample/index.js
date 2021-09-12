// プラグインはgsap.registerPluginで登録
gsap.registerPlugin(ScrollTrigger);

const button = document.querySelector("header");

const tween = gsap.to(button, {
    duration: 0.5,
    // 一時停止状態にする
    paused: true,
    ease: "power2.out",
    width: "100%",
    height: "100px",
    lineHeight: "100px",
    borderRadius: "0%",
    cursor: "default",
    top: 0,
    backgroundColor: "#0FBD94",
    animation: "none"
});

const showContent = () => {
    // 以下のtween.play()とgsap.to()は同じことをしている
    tween.play();
    gsap.to("header h1", {
      opacity: 1,
    });
    // 画像郡を連続的に表示するアニメーションの制御
    gsap.to(".img-container img", {
      opacity: 1,
      delay: 1,
      duration: 1.5,
      y: -10,
      ease: "power2.out",
      // 時間差の表示
      stagger: {
        // 最初の要素から順に表示する
        from: "start",
        amount: 0.8,
      },
    });
    // スクロールイベントの制御
    gsap
      .timeline({
        defaults: { ease: "power2.out", duration: 1.5 },
        scrollTrigger: {
          markers: true, // マーカーを表示するか（開発用）
          trigger: ".content", // この要素と交差するとイベントが発火
          start: "top 50%", // ウィンドウのどの位置を発火の基準点にするか
          end: "bottom 25%", // ウィンドウのどの位置をイベントの終了点にするか
          toggleActions: "play none none none", // スクロールイベントで発火するアニメーションの種類
        },
      })
      .to(".content-text h2", {
        opacity: 1,
        y: -10,
      })
      .to(
        ".content-text p",
        {
          opacity: 1,
          y: -10,
        },
        "-=1"
      ) // 直前のアニメーションにかぶせる
      .to(
        ".content img",
        {
          opacity: 1,
          x: -10,
        },
        "-=1"
      ); // 直前のアニメーションにかぶせる
  };

// ボタンをクリックしたときにshowContent関数を実行する
button.addEventListener("click", showContent);


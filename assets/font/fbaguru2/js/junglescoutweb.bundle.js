(() => {
  let e,
    t,
    u,
    l = !1;
  chrome.storage.local.get(
    ["junglescoutID", "junglescoutPass", "junglescoutURL"],
    function (o) {
      if (o.junglescoutID) {
        (e = o.junglescoutID), (t = o.junglescoutPass), (u = o.junglescoutURL);
        const n = new ClipboardEvent("input", { bubbles: !0 });
        ((c = "[type='email']"),
        new Promise((e) => {
          if (document.querySelector(c)) return e(document.querySelectorAll(c));
          document.arrive(c, function (t) {
            return e(document.querySelectorAll(c));
          });
        })).then((u) => {
          let o = document.querySelector("[type='email']");
          (o.value = e), o.dispatchEvent(n);
          let c = document.querySelector("[type='password']");
          (c.value = t),
            c.dispatchEvent(n),
            chrome.storage.local.set({ junglescoutClose: !0 }),
            setTimeout(() => {
              document.querySelector("button").click(),
                (l = !0),
                clearInterval(interval);
            }, 20);
        });
      }
      var c;
    }
  );
})();
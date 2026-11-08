import "./motion/motion.js";
import { ready, unmountAll } from "./moments/moments.js";

matchMedia("(prefers-reduced-motion: reduce)").addEventListener("change", (event) => {
  if (!event.matches) return;
  document.querySelector(".hero")?.getAnimations({ subtree: true }).forEach((animation) => animation.cancel());
  ready.then(() => unmountAll());
});

const menu = document.querySelector(".mobile-menu");
if (menu) {
  const trigger = menu.querySelector("summary");
  menu.addEventListener("keydown", (event) => {
    if (event.key !== "Escape" || !menu.open) return;
    menu.open = false;
    trigger.focus();
  });
  menu.querySelectorAll('a[href^="#"]').forEach((link) => {
    link.addEventListener("click", () => {
      menu.open = false;
      const target = document.getElementById(link.hash.slice(1));
      if (target) {
        target.setAttribute("tabindex", "-1");
        target.focus({ preventScroll: true });
      }
    });
  });
}

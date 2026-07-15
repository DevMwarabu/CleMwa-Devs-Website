import React from "react";
import { MacbookScroll } from "./ui/macbook-scroll";

export default function MacbookScrollDemo() {
  return (
    <div className="w-full overflow-hidden bg-black dark:bg-[#0B0B0F] text-white">
      <MacbookScroll
        title={
          <span className="text-white">
            Engineering Digital Excellence. <br /> CleMwa Developers.
          </span>
        }
        badge={
          <div className="h-10 w-10 -rotate-12 transform flex items-center justify-center bg-accent-500 rounded-lg">
            <span className="text-white font-bold text-xs">Cle</span>
          </div>
        }
        src={`/images/admin_login_bg.png`}
        showGradient={false}
      />
    </div>
  );
}

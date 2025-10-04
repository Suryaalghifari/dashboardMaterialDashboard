(function () {
	const $root = document.getElementById("chatbot-root");
	const $fab = document.getElementById("chatbot-fab");
	const $sheet = document.getElementById("chatbot-sheet");
	const $close = document.getElementById("chatbot-close");
	const $form = document.getElementById("chatbot-form");
	const $text = document.getElementById("chatbot-text");
	const $msgs = document.getElementById("chatbot-messages");
	const $label = document.getElementById("chat-fab-label");
	if (!$root || !$fab || !$sheet) return;

	const OPEN_URL = $root.dataset.openUrl;
	const SEND_URL_BASE = $root.dataset.sendUrl;

	const escapeHtml = (s) =>
		(s || "").replace(
			/[&<>\"']/g,
			(m) =>
				({
					"&": "&amp;",
					"<": "&lt;",
					">": "&gt;",
					'"': "&quot;",
					"'": "&#039;",
				}[m])
		);
	const scrollToBottom = () => {
		$msgs.scrollTop = $msgs.scrollHeight;
	};

	// Selalu render time WIB
	const fmtWIB = (dateObj) =>
		new Intl.DateTimeFormat("id-ID", {
			timeZone: "Asia/Jakarta",
			hour: "2-digit",
			minute: "2-digit",
		}).format(dateObj) + " WIB";

	// Parse "YYYY-mm-dd HH:ii:ss" sebagai WIB
	function fmtTime(ts) {
		if (!ts) return fmtWIB(new Date());
		const iso = ts.replace(" ", "T") + "+07:00";
		const d = new Date(iso);
		return isNaN(d) ? fmtWIB(new Date()) : fmtWIB(d);
	}

	function addBubble(role, text, ts) {
		const wrap = document.createElement("div");
		wrap.className = "bubble " + role;
		wrap.innerHTML = `<div class="bubble-inner">${escapeHtml(
			text
		)}<div class="bubble-time">${fmtTime(ts)}</div></div>`;
		$msgs.appendChild(wrap);
		scrollToBottom();
	}

	let sessionId = null;

	async function ensureSessionAndGreet() {
		if (sessionId) return;
		try {
			const res = await fetch(OPEN_URL, { method: "POST" });
			const j = await res.json();
			if (j && j.ok) {
				sessionId = j.session_id;

				// Jika ada history → render semuanya & JANGAN greet
				if (Array.isArray(j.messages) && j.messages.length) {
					for (const m of j.messages) {
						addBubble(m.role, m.content, m.created_at);
					}
					return;
				}

				// History kosong → greet sekali per-session
				const key = "cb_greet_" + sessionId;
				if (!localStorage.getItem(key)) {
					addBubble(
						"bot",
						`Halo ${j.user_name}! Ada yang bisa saya bantu?`,
						null
					);
					localStorage.setItem(key, "1");
				}
			}
		} catch (_) {}
	}

	const open = async () => {
		$sheet.setAttribute("aria-hidden", "false");
		const badge = $fab.querySelector(".mdp-fab-badge");
		if (badge) badge.setAttribute("data-count", "0");
		if ($label) $label.style.display = "none";
		await ensureSessionAndGreet();
		setTimeout(() => $text && $text.focus(), 120);
	};
	const close = () => {
		$sheet.setAttribute("aria-hidden", "true");
		if ($label) $label.style.display = "";
	};

	$fab.addEventListener("click", () =>
		$sheet.getAttribute("aria-hidden") !== "false" ? open() : close()
	);
	$close.addEventListener("click", close);
	document.addEventListener("keydown", (e) => {
		if (e.key === "Escape" && $sheet.getAttribute("aria-hidden") === "false")
			close();
	});

	// Enter = kirim
	$text.addEventListener("keydown", (e) => {
		if (e.key === "Enter" && !e.shiftKey) {
			e.preventDefault();
			$form.requestSubmit();
		}
	});

	$form.addEventListener("submit", async (e) => {
		e.preventDefault();
		const val = ($text.value || "").trim();
		if (!val) return;
		addBubble("user", val, null);
		$text.value = "";

		try {
			const res = await fetch(SEND_URL_BASE, {
				method: "POST",
				headers: { "Content-Type": "application/x-www-form-urlencoded" },
				body: new URLSearchParams({ message: val }).toString(),
			});
			const json = await res.json();
			addBubble("bot", json.reply || "Oke!", null);
		} catch {
			addBubble("bot", "Maaf, koneksi bermasalah.", null);
		}
	});

	// expose opsional
	window.ChatbotWidget = { open, close, addBubble };
})();

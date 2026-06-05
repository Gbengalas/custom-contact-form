document.addEventListener("DOMContentLoaded", function () {
  const selectAll = document.getElementById("ccp-select-all");

  if (!selectAll) return;

  selectAll.addEventListener("change", function () {
    const checkboxes = document.querySelectorAll('input[name="message_ids[]"]');

    checkboxes.forEach(function (checkbox) {
      checkbox.checked = selectAll.checked;
    });
  });
});

document.addEventListener("DOMContentLoaded", () => {
  const btn = document.getElementById("ccp-copy-shortcode");
  const input = document.getElementById("ccp-shortcode");

  if (!btn || !input) return;

  btn.addEventListener("click", () => {
    // 1. Select the input text & Copy it using the rock-solid fallback method
    input.select();
    document.execCommand("copy");
    window.getSelection().removeAllRanges(); // Deselect text

    // 2. Change button text feedback
    btn.textContent = "Copied!";
    setTimeout(() => (btn.textContent = "Copy"), 2000);
  });
});

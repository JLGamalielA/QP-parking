import "./bootstrap";

document.addEventListener('input', function (e) {
    if (e.target.classList.contains('limit-chars') && e.target.type === 'number') {
        const max = parseInt(e.target.dataset.max);        
        if (!isNaN(max) && e.target.value.length > max) {
            e.target.value = e.target.value.slice(0, max);
        }
    }
});
document.addEventListener('keydown', function (e) {
    if (e.target.classList.contains('limit-chars') && e.target.type === 'number') {
        const invalidChars = ['e', 'E', '+', '-'];
        
        if (invalidChars.includes(e.key)) {
            e.preventDefault();
        }
    }
});

document.addEventListener('paste', function (e) {
    if (e.target.classList.contains('limit-chars') && e.target.type === 'number') {
        const clipboardData = (e.clipboardData || window.clipboardData).getData('text');
        
        if (/[eE\+\-]/.test(clipboardData)) {
            e.preventDefault();
        }
    }
});
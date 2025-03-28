document.addEventListener('DOMContentLoaded', function () {
    const userInfo = document.getElementById('user-info');
    const logoutBtn = document.getElementById('logout-btn');
    const loginBtn = document.getElementById('login-btn');
    const loginForm = document.getElementById('loginForm');

    // ✅ Xử lý đăng nhập
    if (loginForm) {
        loginForm.addEventListener('submit', function (event) {
            event.preventDefault();
            loginForm.submit(); // Gửi form trực tiếp
        });
    }

    // ✅ Xử lý đăng xuất
    if (logoutBtn) {
        logoutBtn.addEventListener('click', function () {
            document.getElementById('logoutForm').submit(); // Gửi form logout
        });
    }

    updateUserUI();
});

// ✅ Cập nhật giao diện người dùng sau khi đăng nhập
function updateUserUI() {
    const userInfo = document.getElementById('user-info');
    const logoutBtn = document.getElementById('logout-btn');
    const loginBtn = document.getElementById('login-btn');

    if (!userInfo || !logoutBtn || !loginBtn) return;

    let currentUser = document.body.getAttribute('data-user');

    if (currentUser) {
        userInfo.innerHTML = `👤 ${currentUser}`;
        userInfo.style.display = 'inline-block';
        logoutBtn.classList.remove('d-none');
        loginBtn.classList.add('d-none');
    } else {
        userInfo.innerHTML = '';
        userInfo.style.display = 'none';
        logoutBtn.classList.add('d-none');
        loginBtn.classList.remove('d-none');
    }
}

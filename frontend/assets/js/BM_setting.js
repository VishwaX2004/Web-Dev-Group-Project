// Name live update
    document.getElementById('fullName').addEventListener('input', function () {
      const val = this.value.trim();
      const initials = val.split(' ').map(w => w[0]).join('').slice(0, 2).toUpperCase();
      document.getElementById('profileAvatar').textContent = initials || 'KP';
      document.getElementById('avatarNameDisplay').textContent = val || 'Kumara Perera';
    });

    function saveProfile() {
      showToast('✔ Profile saved successfully!', 'success');
    }

    function resetForm() {
      document.getElementById('fullName').value = 'Kumara Perera';
      document.getElementById('profileAvatar').textContent = 'KP';
      document.getElementById('avatarNameDisplay').textContent = 'Kumara Perera';
      showToast('Changes discarded.', 'info');
    }

    function savePassword() {
      const np = document.getElementById('newPw').value;
      const cp = document.getElementById('confPw').value;
      if (!np) { showToast('⚠ New password ඇතුළත් කරන්න.', 'error'); return; }
      if (np !== cp) { showToast('⚠ Passwords match නොවේ.', 'error'); return; }
      showToast('✔ Password updated!', 'success');
      document.getElementById('curPw').value = '';
      document.getElementById('newPw').value = '';
      document.getElementById('confPw').value = '';
    }

    function togglePw(id, btn) {
      const inp = document.getElementById(id);
      inp.type = inp.type === 'password' ? 'text' : 'password';
    }

    function showLogout() { document.getElementById('logoutModal').classList.add('show'); }
    function hideLogout() { document.getElementById('logoutModal').classList.remove('show'); }
    function doLogout() {
      hideLogout();
      showToast('Logging out...', 'info');
      setTimeout(() => { alert('Logged out! (Redirect to login page here)'); }, 1000);
    }

    function showToast(msg, type) {
      const t = document.getElementById('toast');
      t.textContent = msg;
      t.className = 'toast show toast-' + type;
      setTimeout(() => t.className = 'toast', 3000);
    }
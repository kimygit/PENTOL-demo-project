     <header class="p-3 bg-white shadow-sm sticky-top d-flex justify-content-between align-items-center">
        <button class="btn btn-sm btn-light border" id="toggle-btn">
          <i class="bi bi-list"></i>
        </button>

        <div class="dropdown">
        <a href="#" class="d-flex align-items-center text-decoration-none dropdown-toggle" id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false" style="color: var(--pink-wara);">
            <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['username']); ?>&background=ff6363&color=fff" alt="mdo" width="32" height="32" class="rounded-circle me-2">
            <span class="fw-bold d-none d-sm-inline"><?php echo $_SESSION['username']; ?></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-3" aria-labelledby="dropdownUser">
            <li><div class="dropdown-header text-center fw-bold"><?php echo $_SESSION['username']; ?></div></li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <a class="dropdown-item d-flex align-items-center text-danger" href="../inc/logout.php">
                    <i class="bi bi-box-arrow-right me-2"></i> Log Out
                </a>
            </li>
        </ul>
    </div>

      </header>
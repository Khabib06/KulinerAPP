<nav style="background:#0a1f44; padding:12px 20px; display:flex; justify-content:space-between; align-items:center;">

    <div style="color:white; font-weight:bold; font-size:18px;">
        Kuliner Kampus
    </div>

    <div>

        <!-- HOME (SEMUA ROLE) -->
        <a href="/" style="color:#fff; margin-right:15px; text-decoration:none;">
            Home
        </a>

        <?php if (!session()->get('logged_in')): ?>

            <!-- GUEST ONLY -->
            <a href="/login" style="color:#90ee90; margin-right:15px; text-decoration:none;">
                Login
            </a>

        <?php else: ?>

            <!-- USER + ADMIN -->
            <?php if (session()->get('logged_in')): ?>
                <a href="/place/create" style="color:#fff; margin-right:15px; text-decoration:none;">
                    Tambah Tempat
                </a>
            <?php endif; ?>

            <!-- ADMIN ONLY -->
            <?php if (session()->get('role') == 'admin'): ?>
                <a href="/pending-places" style="color:#fff; margin-right:15px; text-decoration:none;">
                    Pending
                </a>

                <a href="/dashboard" style="color:#fff; margin-right:15px; text-decoration:none;">
                    Dashboard
                </a>
            <?php endif; ?>

            <!-- LOGOUT (USER + ADMIN) -->
            <a href="/logout" style="color:#ffdddd; text-decoration:none;">
                Logout
            </a>

        <?php endif; ?>

    </div>

</nav>
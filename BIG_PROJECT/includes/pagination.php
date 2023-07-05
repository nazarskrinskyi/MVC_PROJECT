<?php if (isset($_GET['page'])): ?>
    <div class="pagination-wrapper">
        <nav class="center">
            <ul class="pagination">
                <li class="page-item">
                    <?php
                    if ($_GET['page'] != 1): ?>
                        <a class="page-link" href="main.php?page=<?= $_GET['page'] - 1 ?>" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    <?php
                    endif; ?>
                </li>

                <?php
                for ($i = 0; $i < $all_pages; $i++): ?>
                    <li class="page-item"><a class="page-link" href="main.php?page=<?= $i + 1 ?>"><?= $i + 1 ?></a></li>
                <?php
                endfor; ?>
                <li class="page-item">
                    <?php
                    if ($_GET['page'] != $all_pages): ?>
                        <a class="page-link" href="main.php?page=<?= $_GET['page'] + 1 ?>" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    <?php
                    endif; ?>
                </li>
            </ul>
        </nav>
    </div>
<?php endif; ?>
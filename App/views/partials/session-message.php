<?php if(isset($_SESSION['success_message'])) : ?>
          <div class="message bg-green-100 p-3 my-3">
            <p><?= $_SESSION['success_message'] ?></p>
          </div>
          <?php unset($_SESSION['success_message']) ?>
          <?php endif; ?>

          <?php if(isset($_SESSION['error_message'])) : ?>
          <div class="message bg-green-100 p-3 my-3">
            <p><?= $_SESSION['error_message'] ?></p>
          </div>
          <?php unset($_SESSION['error_message']) ?>
          <?php endif; ?>
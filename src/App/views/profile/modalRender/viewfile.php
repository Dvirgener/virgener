<div class="row">
    <div class="row-fluid d-flex justify-content-center">
        <?php if ($file['file_type'] == "image/jpeg") : ?>
            <img class="border img-fluid" src="/profile/file/<?= $file['id'] ?>" alt="" style="height: auto; width: auto; border-radius:10px">
        <?php elseif ($file['file_type'] == "application/pdf") : ?>
            <iframe src="/profile/file/<?= $file['id'] ?>" frameborder="0" style="height: 800px; width: 800px"></iframe>
        <?php endif ?>
    </div>
</div>
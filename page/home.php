<div class="container">
    <div class="row">
        <?php 
        $tampil = mysqli_query($conn, "SELECT * FROM foto INNER JOIN user ON foto.UserID=user.UserID");
        foreach($tampil as $tampils): 
        ?>
        <div class="col-6 col-md-4 col-lg-3 mb-4">
            <div class="card shadow-sm border-0">
                <img src="uploads/<?= $tampils['LokasiFile'] ?>" class="card-img-top object-fit-cover" style="aspect-ratio: 16/9;">
                <div class="card-body">
                    <h5 class="card-title"><?= $tampils['JudulFoto'] ?></h5>
                    <p class="card-text text-muted">Oleh: <?= $tampils['Username'] ?></p>
                    <a href="?url=detail&&id=<?= $tampils['FotoID'] ?>" class="btn btn-primary">Detail</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

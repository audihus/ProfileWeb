<table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th class="w-25">Judul</th>
                        <th class="w-75">Isi</th>
                        <th class="w-25">Gambar</th>
                        <th class="w-25">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM article ORDER BY tanggal DESC";
                    $hasil = $conn->query($sql);

                    $no = 1;
                    while ($row = $hasil->fetch_assoc()) {
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <strong><?= $row["judul"] ?></strong>
                                <br>pada : <?= $row["tanggal"] ?>
                                <br>oleh : <?= $row["username"] ?>
                            </td>
                            <td><?= $row["isi"] ?></td>
                            <td>
                                <?php
                                if ($row["gambar"] != '') {
                                    if (file_exists('assets/img/' . $row["gambar"] . '')) {
                                ?>
                                        <img src="assets/img/<?= $row["gambar"] ?>" width="100">
                                <?php
                                    }
                                }
                                ?>
                            </td>
                            <td>
                              <a href="#" title="edit" class="badge rounded-pill text-bg-success" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row["id"] ?>"><i class="bi bi-pencil"></i></a>
                              <a href="#" title="delete" class="badge rounded-pill text-bg-danger" data-bs-toggle="modal" data-bs-target="#modalHapus<?= $row["id"] ?>"><i class="bi bi-x-circle"></i></a>
                              <!-- Awal Modal Edit -->
                              <div class="modal fade" id="modalEdit<?= $row["id"] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                              <h1 class="modal-title fs-5" id="staticBackdropLabel">Edit Article</h1>
                                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                          </div>
                                          <form method="post" action="" enctype="multipart/form-data">
                                              <div class="modal-body">
                                                  <div class="mb-3">
                                                      <label for="formGroupExampleInput" class="form-label">Judul</label>
                                                      <input type="hidden" name="id" value="<?= $row["id"] ?>">
                                                      <input type="text" class="form-control" name="judul" placeholder="Tuliskan Judul Artikel" value="<?= $row["judul"] ?>" required>
                                                  </div>
                                                  <div class="mb-3">
                                                      <label for="floatingTextarea2">Isi</label>
                                                      <textarea class="form-control" placeholder="Tuliskan Isi Artikel" name="isi" required><?= $row["isi"] ?></textarea>
                                                  </div>
                                                  <div class="mb-3">
                                                      <label for="formGroupExampleInput2" class="form-label">Ganti Gambar</label>
                                                      <input type="file" class="form-control" name="gambar">
                                                  </div>
                                                  <div class="mb-3">
                                                      <label for="formGroupExampleInput3" class="form-label">Gambar Lama</label>
                                                      <?php
                                                      if ($row["gambar"] != '') {
                                                          if (file_exists('img/' . $row["gambar"] . '')) {
                                                      ?>
                                                              <br><img src="img/<?= $row["gambar"] ?>" width="100">
                                                      <?php
                                                          }
                                                      }
                                                      ?>
                                                      <input type="hidden" name="gambar_lama" value="<?= $row["gambar"] ?>">
                                                  </div>
                                              </div>
                                              <div class="modal-footer">
                                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                  <input type="submit" value="simpan" name="simpan" class="btn btn-primary">
                                              </div>
                                          </form>
                                      </div>
                                  </div>
                              </div>
                              <!-- Akhir Modal Edit -->

                              <!-- Awal Modal Hapus -->
                              <div class="modal fade" id="modalHapus<?= $row["id"] ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                              <h1 class="modal-title fs-5" id="staticBackdropLabel">Konfirmasi Hapus Article</h1>
                                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                          </div>
                                          <form method="post" action="" enctype="multipart/form-data">
                                              <div class="modal-body">
                                                  <div class="mb-3">
                                                      <label for="formGroupExampleInput" class="form-label">Yakin akan menghapus artikel "<strong><?= $row["judul"] ?></strong>"?</label>
                                                      <input type="hidden" name="id" value="<?= $row["id"] ?>">
                                                      <input type="hidden" name="gambar" value="<?= $row["gambar"] ?>">
                                                  </div>
                                              </div>
                                              <div class="modal-footer">
                                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">batal</button>
                                                  <input type="submit" value="hapus" name="hapus" class="btn btn-primary">
                                              </div>
                                          </form>
                                      </div>
                                  </div>
                              </div>
                              <!-- Akhir Modal Hapus -->  
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
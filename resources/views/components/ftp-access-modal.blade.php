
    <div class="modal fade" id="ftpAccessModal" tabindex="-1" role="dialog" aria-labelledby="ftpAccessTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="ftpAccessTitle">Заголовок</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                  <label for="ftpHost" class="col-sm-3 col-form-label">Хост:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="ftpHost" name="ftp_host" value="hoster" readonly autocomplete="off" style="background: #fff;color:#000;border:none;">
                  </div>
                </div>
                <div class="form-group row">
                  <label for="ftpLogin" class="col-sm-3 col-form-label">Логин:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="ftpLogin" name="ftp_user" value="login" readonly autocomplete="off" style="background: #fff;color:#000;border:none;">
                  </div>
                </div>
              <div class="form-group row">
                <label for="ftpPassword" class="col-sm-3 col-form-label">Пароль:</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="ftpPassword" name="ftp_pass" value="password" readonly autocomplete="off" style="background: #fff;color:#000;border:none;">
                </div>
              </div>
              <div class="form-group row">
                <label for="fieldMetrika" class="col-sm-3 col-form-label">Метрика:</label>
                <div class="col-sm-9">
                  <a href="#" id="fieldMetrika" class="form-control" style="background: #fff;color:#000;border:none;" target="_blank"></a>
                </div>
              </div>
              <div class="form-group row">
                <label for="fieldPixel" class="col-sm-3 col-form-label">Пиксель:</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="fieldPixel" name="facebook" value="password" readonly autocomplete="off" style="background: #fff;color:#000;border:none;">
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal" id="modalClose">Закрыть</button>
            </div>
          </div>
        </div>
      </div>

<script>
    $("body").on('click', '#openModalFtp', function(){
        $("#ftpAccessTitle").html($(this).data('ftp-name'));
        $("#ftpHost").val($(this).data('ftp-host'));
        $("#ftpLogin").val($(this).data('ftp-user'));
        $("#ftpPassword").val($(this).data('ftp-pass'));
        $("#fieldMetrika").html($(this).data('yandex'));
        if ($(this).data('yandex') != '') {
          $("#fieldMetrika").attr("href", "https://metrika.yandex.ru/dashboard?id=" + $(this).data('yandex'));
        } else {
          $("#fieldMetrika").attr("href", "#");
        }
        $("#fieldPixel").val($(this).data('facebook'));
    });
</script>

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
              <div class="form-group row">
                <label for="fieldCreator" class="col-sm-3 col-form-label">Добавил:</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="fieldCreator" name="creator" value="" readonly autocomplete="off" style="background: #fff;color:#000;border:none;">
                </div>
              </div>
              <div class="form-group row">
                <label for="fieldAdded" class="col-sm-3 col-form-label">Добавлен:</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="fieldAdded" name="facebook" value="created_at" readonly autocomplete="off" style="background: #fff;color:#000;border:none;">
                </div>
              </div>
              <div class="form-group row">
                <label for="fieldUpdator" class="col-sm-3 col-form-label">Обновил:</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="fieldUpdator" name="updator" value="" readonly autocomplete="off" style="background: #fff;color:#000;border:none;">
                </div>
              </div>
              <div class="form-group row">
                <label for="fieldUpdated" class="col-sm-3 col-form-label">Обновлён:</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="fieldUpdated" name="facebook" value="updated_at" readonly autocomplete="off" style="background: #fff;color:#000;border:none;">
                </div>
              </div>
              <div class="form-group row">
                <a href="" class="col-sm-12 col-form-label">История изменений</a>
              </div>
            </div>
            <div class="modal-footer">
              <a href="#" id="winScpOpen" class="btn btn-success">Открыть в WinSCP</a>
              <a href="#" id="ftpOpen" class="btn btn-primary">Перейти на FTP</a>
              <a href="#" id="ftpEditError" class="btn btn-danger">Настройки данных</a>
              <button type="button" class="btn btn-secondary" data-dismiss="modal" id="modalClose">Закрыть</button>
            </div>
          </div>
        </div>
      </div>

<script>
    $("body").on('click', '#openModalFtp', function(){
        if ($(this).data('ftp-host') != '') {
          var winScpLink = 'winscp-ftp://' + $(this).data('ftp-user') + ':' + $(this).data('ftp-pass') + '@' + $(this).data('ftp-host');
          var ftpLink = 'ftp://' + $(this).data('ftp-user') + ':' + $(this).data('ftp-pass') + '@' + $(this).data('ftp-host');
          $("#winScpOpen").attr("href", winScpLink);
          $("#ftpOpen").attr("href", ftpLink);
        } else {
          $("#winScpOpen").attr("href", "#");
          $("#ftpOpen").attr("href", "#");
        }

        if ($(this).data('siteid') != '') {
          var ftpSiteId = $(this).data('siteid');
          var ftpEditLink = '{{ route('sites.edit.settings', ['id' => 'here_site_id']) }}';
          var ftpEditLink = ftpEditLink.replace('here_site_id', ftpSiteId);
          $("#ftpEditError").attr("href", ftpEditLink);
        } else {
          $("#ftpEditError").attr("href", "#");
        }

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
        if ($(this).data('creator') != '') {
          $("#fieldCreator").val($(this).data('creator'));
        } else {
          $("#fieldCreator").val('');
        }
        if ($(this).data('updator') != '') {
          $("#fieldUpdator").val($(this).data('updator'));
        } else {
          $("#fieldUpdator").val('');
        }
        $("#fieldAdded").val($(this).data('createdat'));
        $("#fieldUpdated").val($(this).data('updatedat'));
    });
</script>
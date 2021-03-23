
    <div class="modal fade" id="additionalModal" tabindex="-1" role="dialog" aria-labelledby="ftpAccessTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="ftpAccessTitle">Дополнительная информация по хостеру</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                  <div class="col-sm-12">
                        <pre id="additional_text" style="font-family: inherit;font-size: 1rem;"></pre>
                    </div>
                </div>
               
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal" id="modalClose">Закрыть</button>
            </div>
          </div>
        </div>
      </div>

<script>
    $("body").on('click', '#openAdditionalModal', function(){
        $("#additional_text").html($(this).data('additional'));
    });
</script>
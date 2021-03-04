
    <div class="modal fade" id="transferSiteUserModal" tabindex="-1" role="dialog" aria-labelledby="transferSiteTitle" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <form action="{{ route('sites.transfer') }}" method="post">
            @csrf
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="transferSiteTitle">Передать сайт</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                    <input type="hidden" name="siteid" id="siteDomainHidden">
                    
                    <div class="form-group row">
                        <label for="siteUser" class="col-sm-12 col-form-label">Пользователь</label>
                        <div class="col-sm-12">
                        <select class="form-control change-user" id="siteUser" name="user_id">
                            <option value="0">Без пользователя</option>
                            @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->realname }} - {{ $user->name }} ({{ $user->pid }})</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Передать</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal" id="modalClose">Закрыть</button>
            </div>
          </div>
        </form>
        </div>
      </div>

      <script>
          $("body").on('click', '#transferSite', function(){
              $("#transferSiteTitle").html("Передать сайт" + $(this).data('domain'));
              $("#siteDomainHidden").val($(this).data('siteid'));
          });
      </script>
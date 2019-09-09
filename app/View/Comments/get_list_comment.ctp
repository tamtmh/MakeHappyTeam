<?php foreach ($comment as $key => $result):?>
    <div class="row" style="margin-left: 20px;margin-right: 20px">
        <div class="media comment-box">
            <div class="media-left">
                <div class="avatar_menu">
                    <?= (isset($result['TUser']['avatar_user']) && !empty($result['TUser']['avatar_user'])) ? $this->Html->image("avatar_user/" . $result['TUser']['avatar_user']) : $this->Html->image('user.png'); ?>
                </div>
            </div>
            <div class="media-body">
                <h6 class="media-heading"><b><?php echo $result['TUser']['username'];?></b>  <i><?php echo $result['TComment']['created'];?></i></h6>
                <div class="media-content">
                    <p class="comment-content"><?php echo $result['TComment']['content'];?></p>
                    <div class="col-md-12 translate">
                        <button type="button" class="btn btn-info cmtVN">VN</button>
                        <button type="button" class="btn btn-success cmtEN">EN</button>
                        <button type="button" class="btn btn-warning cmtJP">JP</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
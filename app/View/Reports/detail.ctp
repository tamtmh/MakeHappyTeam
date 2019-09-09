<?php echo $this->element("name_team"); ?>
<hr>
<div class="row">
    <div class="col-md-2 col-sm-2 col-5 emoji">
        <h5>Status</h5>
        <?php echo $this->Html->image('emoji/emoji_' . $report['TReport']['emoji_id'] . '.gif'); ?>
    </div>
    <div class="col-md-2 col-sm-2 col-5 score">
        <h5>Score</h5>
        <p>
            <?php echo $report['TReport']['score']; ?>
        </p>
    </div>
    <div class="col-md-7 col-sm-7 col-11 status">
        <h4 style ="margin: 7%;">
            <?php echo $report['TReport']['status']; ?>
        </h4>
    </div>
</div>
<div class="title-report">
    <p><i class="fa fa-tasks" aria-hidden="true"></i> Report</p>
</div>
<hr>
<div class="row answer">
    <div class="col-md-12 col-sm-12 col-12 viewanswer">
        <?php
            $i = 0;
            foreach ($report['TReport']['report_detail'] as $key => $content) {
                foreach ($content as $question => $answer) {
                    $i++;
                    echo "<span><p>".$i."  ".$question."</p></span><i>".$answer."</i>";
                }
            }
        ?>
    </div>
    <div class="col-md-12 col-sm-12 col-12 result_translate">
    </div>
    <div class="col-md-12 col-sm-12 col-12 translate">
        <button type="button" class="btn btn-info btnVN">VN</button>
        <button type="button" class="btn btn-success btnEN">EN</button>
        <button type="button" class="btn btn-warning btnJP">JP</button>
    </div>
</div>
<div class="comment">
    <div class="row">
        <div class="col-md-1 col-sm-1 col-3 avatar_cmt">
            <div class="avatar avatar_round">
                <?= (isset($authUser['avatar_user']) && !empty($authUser['avatar_user'])) ? $this->Html->image("avatar_user/" . $authUser['avatar_user']) : $this->Html->image('user.png'); ?>
            </div>
        </div>
        <div class="col-md-11 col-sm-11 col-9 formCmt">
            <form class="form-inline">
                <textarea class="form-control col-md-11 contentCmt" rows="1" maxlength="100" onkeypress="process(event, this)"></textarea>
                <button type="button" id="btnCmt" teamID="<?= $report['TReport']['team_id'];?>" data-user="<?= $report['TReport']['user_id'];?>" data="<?= $report['TReport']['id'];?>"><i class="fa fa-pencil-square-o fa-2x text-info" aria-hidden="true"></i></button>
            </form>
        </div>
    </div>
    <h5><i class="fa fa-comments-o fa-lg"></i>Comments</h5>
    <div id="list-comment-box">
        <?php foreach ($comment as $key => $result): ?>
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
    </div>
</div>
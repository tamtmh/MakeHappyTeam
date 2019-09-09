<?php echo $this->element("name_team"); ?>
<?php if(!empty($teamInfo)): ?>
<hr>
<div class="homepage">
    <?php if (isset($report)) : ?>
    <div class="row">
        <div class="col-md-2 col-sm-2 col-5 emoji">
            <h5>Status</h5>
            <?php echo $this->Html->image('emoji/emoji_'.$report['TReport']['emoji_id'].'.gif'); ?>
        </div>
        <div class="col-md-2 col-sm-2 col-5 score">
            <h5>Score</h5>
            <p>
                <?php echo $report['TReport']['score'] ?>
            </p>
        </div>
        <div class="col-md-7 col-sm-7 col-11 status">
            <h4 style ="margin: 7%;">
                <?php echo $report['TReport']['status'] ?>
            </h4>
        </div>
    </div>
    <?php else : ?>
    <form action="" method="post" id="fr_form">
        <div class="form-group">
        </div>
        <div class="row">
            <div class="col-md-3 col-sm-12 col-12">
                <div class="card" id="emoji">
                    <h5 class="card-header">Status</h5>
                    <div class="card-body" id="selectemoji">
                        <input type="image" onclick="return false;" id="image_emoji_1" alt="Login" src="/img/emoji/emoji_1.gif" autocomplete="off" name="select_emoji">
                        <input type="image" onclick="return false;" id="image_emoji_2" alt="Login" src="/img/emoji/emoji_2.gif" autocomplete="off" name="select_emoji">
                        <input type="image" onclick="return false;" id="image_emoji_3" alt="Login" src="/img/emoji/emoji_3.gif" autocomplete="off" name="select_emoji">
                    </div>
                </div>

            </div>
            <div class="col-md-2 col-sm-12 col-12">
                <div class="card">
                    <h5 class="card-header">Score</h5>
                    <div class="card-body">
                        <select class="form-control form-score" id="score_val" name="score">
                                <?php
                                    for($i=10; $i<=100; $i+=10) {
                                        echo "<option value=" .$i.">$i</option>";
                                    }
                                ?>
                            </select>
                    </div>
                </div>
            </div>
            <div class="col-md-7 col-sm-12 col-12">
                <textarea name="textview-report" class="whatsay form-control" cols="" placeholder="What do you say?"
                          id="textarea-whatsay" maxlength="100"></textarea>
                <button type="button" class="btn btn-primary sendreport" id="sent_report_index">Send</button>
            </div>
        </div>
    </form>
    <?php endif?>
    
    <input type="hidden" id="teamIDReport" name="" value="<?= $teamInfo['TTeam']['id']; ?>">

    <div class="history">
        <p class="title-history"><i class="fa fa-history" aria-hidden="true"></i> History</p>
        <hr class="my-4">
        <table class="table table-hover" id="table-add-report">
            <thead class="thead-light">
                <tr>
                    <th scope="col" style="width: 15%;">Date</th>
                    <th scope="col" style="width: 20%;">Status</th>
                    <th scope="col" style="width: 15%;">Score</th>
                    <th scope="col">Comment</th>
                    <th scope="col" style="width: 10%;">Report</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach($results as $key => $result) {
                ?>
                    <tr>
                        <td>
                            <?php 
                        $date =  $result['TReport']['created']; 
                        echo  date('Y-m-d', strtotime($date));
                        ?>
                        </td>
                        <td>
                        <?php
                            echo $this->Html->image("emoji/emoji_".$result['TReport']['emoji_id'].".gif", array('width' => "30%"));
                        ?>
                        </td>
                        <td>
                            <?php echo $result['TReport']['score'] ?>
                        </td>
                        <td>
                            <?php echo $result['TReport']['status'] ?>
                        </td>
                        <td>
                            <?php if ($result['TReport']['report_status'] == 1) {?>
                                <a href="/reports/create/<?php echo $result['TReport']['id'] ?>" type="button " class="btn btn-primary btn-sm btnRequestMember">Response</a>
                            <?php } elseif ($result['TReport']['report_status'] == 2) { ?>
                                <a href="/reports/detail/<?php echo $result['TReport']['id'] ?>" type="button " class="btn btn-success btn-sm btnDetail">Detail</a>
                            <?php }  ?>
                        </td>
                </tr>
                <?php } ?>

            </tbody>
        </table>
        <?php echo $this->element('pagining_links'); ?>
    </div>
</div>
<?php else: ?>
<?php echo $this->Session->flash(); ?>
<p style=" text-align: center; padding-top: 15px;">No data found. Please join to a Team!</p>
<?php endif;?>
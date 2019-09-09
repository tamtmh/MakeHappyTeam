<?php if(!empty($listTeams)): ?>
<?php echo $this->element("name_team"); ?>
<hr>
<div class="homepage">
    <div class="form-group title-date">
        <input type="text" name="dates" style="padding: 5px 8px;border: 0.5px solid #e7e7e7;" value="<?php echo $today; ?>" id="dateRange"/>

        <select id="member-in-team">
            <option value="">All member</option>
            <?php foreach($allMemberTeam as $nameTeam):?>
                <option value="<?= $nameTeam['TUser']['id']?>"><?= $nameTeam['TUser']['username']?></option>
            <?php endforeach; ?>
        </select>

    </div>
    <?php if(isset($results) && !empty($results)) :?>
    <div class="history" id="lead-list-report">
        <table class="table table-hover" id="table-leader-team">
            <thead class="thead-light">
            <tr>
                <th scope="col" style="width: 15%;">Date</th>
                <th scope="col" style="width: 15%;">Member</th>
                <th scope="col" style="width: 20%;">Status</th>
                <th scope="col" style="width: 15%;">Score</th>
                <th scope="col">Comment</th>
                <th scope="col" style="width: 15%;">Report</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($results as $key => $result): ?>
            <tr class="member-in-team-filter">
                <td>
                    <?php
                            $date =  $result['TReport']['created'];
                            echo  date('Y-m-d', strtotime($date));
                        ?>
                </td>
                <td><?php echo $result['TUser']['username'] ?></td>
                <td>
                    <?php
                            echo $this->Html->image("emoji/emoji_".$result['TReport']['emoji_id'].".gif", array('width' => "30%"));
                    ?>
                </td>
                <td><?php echo $result['TReport']['score'] ?></td>
                <td><?php echo $result['TReport']['status'] ?></td>
                <td>
                    <?php
                        if ($result['TReport']['report_status'] == 0):
                        ?>
                    <button type="button " class="btn btn-primary btn-sm btnRequest" reportID = "<?php echo $result['TReport']['id'] ?>" dataID="<?php echo $result['TReport']['user_id'] ?>" <?php echo ($result['TReport']['user_id'] == $authUser['id'])?'disabled':''; ?>>Request</button>
                    <?php elseif ($result['TReport']['report_status'] == 1): ?>
                    <button type="button " class="btn btn-warning btn-sm btnProgress">In Progress</button>
                    <?php else: ?>
                    <a href="/reports/detail/<?php echo $result['TReport']['id'] ?>" type="button " class="btn btn-success btn-sm btnDetail">Detail</a>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
        <?php echo $this->element('pagining_links'); ?>
    </div>
    <?php else: ?>
        <p style="padding-top: 20px;">No data found.</p>
    <?php endif;?>

</div>
<?php else: ?>
<p style=" text-align: center; padding-top: 20px;">No data found. Please create a team!</p>
<?php endif;?>

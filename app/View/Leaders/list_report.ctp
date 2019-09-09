<?php if(!empty($results)): ?>
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
    <tbody id="fbody">
        <?php
            foreach($results as $key => $result) {
        ?>
        <tr class="member-in-team-filter">
            <td>
                <?php 
                    $date =  $result['TReport']['created']; 
                    echo  date('Y-m-d', strtotime($date));
                ?>
            </td>
            <td class="name-member"><?php echo $result['TUser']['username'] ?></td>
            <td>
                <?php
                    echo $this->Html->image("emoji/emoji_".$result['TReport']['emoji_id'].".gif", array('width' => "30%"));
                ?>
            </td>
            <td><?php echo $result['TReport']['score'] ?></td>
            <td><?php echo $result['TReport']['status'] ?></td>
            <td>
                <?php 
                    if ($result['TReport']['report_status'] == 0) {
                ?>
                <button type="button " class="btn btn-primary btn-sm btnRequest" dataLeader = "<?php echo $authUser['username'];?>" reportID = "<?php echo $result['TReport']['id'] ?>" dataID="<?php echo $result['TReport']['user_id'] ?>">Request</button>
            <?php } elseif ($result['TReport']['report_status'] == 1) { ?>
                <button type="button " class="btn btn-warning btn-sm btnProgress">In Progress</button>
            <?php } else { ?>
                <a href="/reports/detail/<?php echo $result['TReport']['id'] ?>" type="button " class="btn btn-success btn-sm btnDetail">Detail</a>
            <?php }  ?>
            </td>
        </tr>
        <?php } ?>
        
    </tbody>
</table>
<?php echo $this->element('pagining_links'); ?>
<?php else: ?>
<p style="padding-top: 20px;">No data found.</p>
<?php endif;?>
<!-- Modal add_edit_member-->
<div class="modal fade" id="addAndEditMember" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Member <span><i class="fa fa-refresh btn-refresh ref-add-list-edit" aria-hidden="true" data-teamID="<?= $teamInfo['TTeam']['id']; ?>"></i><?= $this->Html->image('loading.gif', array('class' => 'refresh-loading d-none', 'width' => '18px')) ?></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active nav-link-tab-manager" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false"><i class="fa fa-plus-square-o" aria-hidden="true"></i> Add</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-tab-manager" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-tab-manager" id="pills-contact-tab" data-toggle="pill" href="#pills-list" role="tab" aria-controls="pills-contact" aria-selected="false"><i class="fa fa-list" aria-hidden="true"></i>List</a>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <!-- add member -->
                    <div class="tab-pane fade show active" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                        <input class="form-control mr-sm-2 search-popup search" type="search" placeholder="Search" aria-label="Search">
                        <div class="form-check check-popup checkbox-item">
                            <input class="form-check-input selectAll" type="checkbox" value="">
                            <label class="form-check-label">Select all</label>
                        </div>
                        <hr style="margin-bottom: 0px;">
                        <div class="list-add-member scroll_text scroll-y">
                            <?php foreach ($listAddMember as $member): ?>
                                <div class="form-check check-popup checkbox-item">
                                    <input class="form-check-input checkMember" name="memberID" type="checkbox" value="<?= $member['TUser']['id']; ?>">
                                    <label class="form-check-label"><?= $member['TUser']['username']; ?></label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="modal-footer">
                            <div class="alert statusAddMember" role="alert"></div>
                            <button type="button" class="btn btn-secondary btn-popup" data-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary btn-popup" teamID="<?= $teamInfo['TTeam']['id'];?>" teamName="<?= $teamInfo['TTeam']['name']?>" id="saveAddmember">Save</button>
                        </div>
                    </div>
                    <!-- edit member -->
                    <div class="tab-pane fade edit-member" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                        <input class="form-control mr-sm-2 search-popup search" type="search" placeholder="Search" aria-label="Search">
                        <div class="scroll-y">
                            <table class="table table-popup list-members-in-team" id="tableEditMember">
                                <tbody class="list-edit-member">
                                <?php foreach ($listMemberInTeam as $key => $val): ?>
                                    <tr class="user-id checkbox-item" data-id="<?php echo $val['TUserTeam']['id']; ?>" data-teamId="<?php echo $val['TUserTeam']['team_id']; ?>" id="<?php echo $val['TUserTeam']['id']; ?>">
                                        <th scope="row"><?= $key + 1; ?></th>
                                        <td class="user-name"><?= $val['TUser']['username'] ?></td>
                                        <td>
                                            <select class="select-popup role-team">
                                                <?php foreach ($listRoleTeam as $role) { ?>
                                                    <option <?php if ($val['TUserTeam']['role_team_id'] == $role['TRoleTeam']['id']) { ?> selected <?php } ?>value="<?= $role['TRoleTeam']['id']; ?>"><?= $role['TRoleTeam']['name'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
                                        <td class="delete-member-in-team"><i class="fa fa-times" aria-hidden="true"></i>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <div class="modal-footer">
                            <div class="alert alert-success" id="editMemberInTeamSuccess" role="alert">You have edited success!</div>
                            <button type="button" class="btn btn-secondary btn-popup" data-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary btn-popup delete-member-team" id="saveEditMemberTeam">Save</button>
                        </div>

                    </div>
                    <!--list member-->
                    <div class="tab-pane fade show list-member" role="tabpanel" id="pills-list" aria-labelledby="pills-profile-tab">
                        <hr>
                        <p>Leader:</p>
                        <?php
                        foreach ($allMemberTeam as $member):
                            if($member['TUserTeam']['role_team_id'] == 1):
                                ?>
                                <div class="avatar_menu" data-tooltip="<?= $member['TUser']['username'];?>">
                                    <?= (isset($member['TUser']['avatar_user']) && !empty($member['TUser']['avatar_user'])) ? $this->Html->image("avatar_user/" . $member['TUser']['avatar_user']) : $this->Html->image("user.png") ?>
                                </div>
                            <?php endif; endforeach; ?>
                        <p>Member:</p>
                        <?php
                        foreach ($allMemberTeam as $member):
                            if($member['TUserTeam']['role_team_id'] == 2):
                                ?>
                                <div class="avatar_menu" data-tooltip="<?= $member['TUser']['username'];?>">
                                    <?= (isset($member['TUser']['avatar_user']) && !empty($member['TUser']['avatar_user'])) ? $this->Html->image("avatar_user/" . $member['TUser']['avatar_user']) : $this->Html->image("user.png") ?>
                                </div>
                            <?php endif; endforeach; ?>
                        <div class="modal-footer">
                            <div class="alert statusAddMember" role="alert"></div>
                            <button type="button" class="btn btn-secondary btn-popup" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal add_team-->
<div class="modal fade" id="addTeamModalCenter" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Team</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" id="frm-add-team">
                    <div class="row">
                        <div class="col-md-3 upload-avartar-team">

                            <img src="/img/logo.png" class="avatar-team"/>
                            <input type="file" id="avatar-team-add" name="avatar" style="display: none;">
                            <div class="icon-upload-file-add-team">
                                <p class="title-upload-file"><i class="fa fa-camera-retro fa-lg"></i> Update photo</p>
                            </div>



                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" placeholder="Name">
                            </div>
                            <div class="form-group description-popup">
                                <label>Description about team</label>
                                <textarea rows="2" name="des" cols="40" class="form-control" placeholder="This is description team"></textarea>
                            </div>
                        </div>
                    </div>
                    <input class="form-control mr-sm-2 search-popup search" type="search" class="input-search" placeholder="Search" aria-label="Search">
                    <div class="member-in-team">
                        <div class="tab-pane fade show active tab-add-body" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            <div class="form-check check-popup panel-action checkbox-item">
                                <input class="form-check-input selectAll" type="checkbox" value="">
                                <label class="form-check-label">Select all</label>
                            </div>
                            <hr style="margin-bottom: 0px;">
                            <div class="list-account scroll_text scroll-y">
                                <?php if (isset($listAccount) && !empty($listAccount)): ?>
                                    <?php foreach ($listAccount as $account): ?>
                                        <div class="form-check check-popup checkbox-item">
                                            <input class="form-check-input" name="members[]" type="checkbox" value="<?php echo $account['TUser']['id']; ?>">
                                            <label class="form-check-label"><?php echo $account['TUser']['username']; ?></label>
                                        </div>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div class="alert show-status" role="alert"></div>
                <button type="button" class="btn btn-secondary btn-popup" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary btn-popup btn-add-team">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal edit_team-->
<div class="modal fade" id="editTeamModalCenter" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Team <span><i class="fa fa-refresh btn-refresh ref-edit" aria-hidden="true" data-teamID="<?= $teamInfo['TTeam']['id']; ?>"></i><?= $this->Html->image('loading.gif', array('class' => 'refresh-loading d-none', 'width' => '18px')) ?></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" id="frm-edit-team">
                    <div class="row">
                        <div class="col-md-3 upload-avartar-team">
                            <?= (!empty($teamInfo['TTeam']['avatar']) && WWW_ROOT . 'img/avatar_team/'.$teamInfo['TTeam']['avatar']) ? $this->Html->image('avatar_team/'.$teamInfo['TTeam']['avatar'], array('class' => 'avatar-team-edit')) : $this->Html->image('logo.png', array('class' => 'avatar-team-edit')); ?>
                            <input type="file" id="avatar-team-edit-file" name="avatar" style="display: none;">
                            <div class="icon-upload-file">
                                <p class="title-upload-file"><i class="fa fa-camera-retro fa-lg"></i> Update photo</p>
                            </div>
                        </div>
                        <div class="col-md-9">

                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" id="nameTeam" name="name"  value="<?= $teamInfo['TTeam']['name']?>" placeholder="<?= $teamInfo['TTeam']['name']?>">
                            </div>
                            <div class="form-group description-popup">
                                <label>Description about team</label>
                                <textarea rows="2" cols="40" class="form-control" name="des" id="desTeam"><?= $teamInfo['TTeam']['des']?></textarea>
                            </div>
                            <input type="hidden" name="team_id" value="<?= $teamInfo['TTeam']['id'];?>">
                        </div>
                    </div>
                    <input class="form-control mr-sm-2 search-popup search" type="search" placeholder="Search" aria-label="Search">
                    <!-- if edit team -->
                    <div class="scroll_text scroll-y">
                        <table class="table table-popup list-members-in-team" id="list-members-team">
                            <tbody class="list-edit-member">
                            <?php foreach ($listMemberInTeam as $key => $val): ?>
                                <tr class="user-id checkbox-item" data-id="<?php echo $val['TUserTeam']['id']; ?>" data-teamId="<?php echo $val['TUserTeam']['team_id']; ?>" id="<?php echo $val['TUserTeam']['id']; ?>">
                                    <th scope="row"><?= $key + 1; ?></th>
                                    <td><?= $val['TUser']['username'] ?></td>
                                    <td>
                                        <select class="select-popup role-team" id="role-team-edit">
                                            <?php foreach ($listRoleTeam as $role): ?>
                                                <option <?php if ($val['TUserTeam']['role_team_id'] == $role['TRoleTeam']['id']){ ?> selected <?php } ?>value="<?= $role['TRoleTeam']['id']; ?>"><?= $role['TRoleTeam']['name']; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </td>
                                    <td class="delete-member-in-team">
                                        <i class="fa fa-times" aria-hidden="true"></i>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </form>
                <!-- end if edit team -->
            </div>
            <div class="modal-footer">
                <div class="alert show-status" role="alert"></div>
                <button type="button" class="btn btn-secondary btn-popup" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary btn-popup delete-member-team" id="editTeam">Save</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal delete_team-->
<div class="modal fade" id="confirm-delete-team" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Confirm Delete</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="">&times;</button>
            </div>

            <div class="modal-body">
                <p>Do you want to delete <?= $teamInfo['TTeam']['name'];?>?</p>
                <p class="debug-url"></p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <a data-id ="<?= $teamInfo['TTeam']['id'];?>" class="btn btn-danger btn-ok">Delete</a>
            </div>
        </div>
    </div>
</div>

<!-- profile -->
<div class="modal fade" id="user-profile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <?php if (isset($authUser) && !empty($authUser)): ?>
                <div class="profile-cover-content">
                    <div class="cover-image"><?= (isset($authUser['cover_image']) && !empty($authUser['cover_image'])) ? $this->Html->image("avatar_user/" . $authUser['cover_image'], array('class' => 'cover-photo')) : $this->Html->image("cover-photo.jpg", array('class' => 'cover-photo')) ; ?></div>
                    <input type="file" id="avatar-cover-file" name="avatar" style="display: none;">
                    <div class="update-cover-photo">
                        <p><i class="fa fa-camera-retro fa-lg"></i> Update photo</p>
                    </div>
                    <div class="alert-upload-file-cover" role="alert"><span>Update cover successfully!</span></div>
                    <div class="username">
                        <span></span><?php echo $authUser['username'];?></span>
                    </div>
                    <div class="user-email">
                        <span><?php echo $authUser['email'];?></span>
                    </div>
                </div>
                <div class="photoView" href="">
                    <?= (isset($authUser['avatar_user']) && !empty($authUser['avatar_user'])) ? $this->Html->image("avatar_user/" . $authUser['avatar_user'], array('class' => 'avatar-user')) : $this->Html->image('user.png', array('class' => 'avatar-user')); ?>
                    <input type="file" id="avatar-user-file" name="avatar" style="display: none;">
                    <div class="upload-avatar-user">
                        <i class="fa fa-camera-retro fa-lg"></i>Update
                    </div>
                    <div class="alert-upload-file" role="alert"><span class="alert-success">Update successfully!</span></div>
                </div>
                <div class="pn-call-action float-right">
                    <button class="btn btn-outline-primary edit-profile"><i class="fa fa-pencil" aria-hidden="true"></i> Edit profile</button>
                    <div class="act-h d-none">
                        <button class="btn btn-primary save-profile"><i class="fa fa-check" aria-hidden="true"></i> Save</button>
                        <button class="btn btn-secondary edit-cancel"><i class="fa fa-undo" aria-hidden="true"></i> Cancel</button>
                    </div>
                </div>
                <div class="profile-content-text">
                    <div class="textContainer">
                        <div class="row">
                            <form action="#" id="frm-user-profile">
                                <input type="hidden" name="id" value="<?php echo $authUser['id'] ?>">
                                <table class="table table-user-information">
                                    <tbody>
                                    <tr>
                                        <td>Date of birth:</td>
                                        <td class="hide-af-edit date_of_birth"><?= (isset($authUser['date_of_birth']) && !empty($authUser['date_of_birth'])) ? date('Y-m-d', strtotime($authUser['date_of_birth'])) : ''  ?></td>
                                        <td class="ip-h d-none"><input type="text" name="date_of_birth" class="datepicker date_of_birth form-control" placeholder="mm/dd/yyyy" value="<?= (isset($authUser['date_of_birth']) && !empty($authUser['date_of_birth'])) ? date('Y-m-d', strtotime($authUser['date_of_birth'])) : ''  ?>"></td>
                                    </tr>
                                    <tr>
                                        <td>Phone Number:</td>
                                        <td class="hide-af-edit phone_number"><?= (isset($authUser['phone_number']) && !empty($authUser['phone_number'])) ? $authUser['phone_number'] : ''  ?></td>
                                        <td class="ip-h d-none"><input type="text" name="phone_number" class="phone_number form-control" placeholder="0xxxxxxxx" value="<?= (isset($authUser['phone_number']) && !empty($authUser['phone_number'])) ? $authUser['phone_number'] : ''  ?>"></td>
                                    </tr>
                                    <tr>
                                        <td>Facebook:</td>
                                        <td class="hide-af-edit facebook">
                                            <?= (isset($authUser['facebook']) && !empty($authUser['facebook'])) ? "<a href=". $authUser['facebook'] .">" . $authUser['facebook'] . "</a>" : ''  ?>
                                        </td>
                                        <td class="ip-h d-none"><input type="text" name="facebook" class="facebook form-control" placeholder="https://www.facebook.com" value="<?= (isset($authUser['facebook']) && !empty($authUser['facebook'])) ? $authUser['facebook'] : ''  ?>"></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="alert show-status" role="alert"></div>
            <div class="modal-footer">
                <div class="alert alert-danger message-error-upload-file" role="alert" style="display: none"></div>
                <button type="button" class="btn btn-secondary btn-popup" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
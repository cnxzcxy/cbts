<?php include('common_header.php');?>
    <div class="pageheader">
      <h2><i class="fa fa-pencil"></i> 任务管理 <span>任务详情</span></h2>
      <div class="breadcrumb-wrapper">
        <span class="label">你的位置:</span>
        <ol class="breadcrumb">
          <li><a href="/">我的控制台</a></li>
          <li><a href="/tice/task_list">任务管理</a></li>
          <li class="active">任务详情</li>
        </ol>
      </div>
    </div>
    
    <div class="contentpanel">
      <div class="row">
        <div class="col-sm-3 col-lg-2">
          <ul class="nav nav-pills nav-stacked nav-email">
            <li><a href="/issue"><i class="glyphicon glyphicon-folder-close"></i> 任务列表</a></li>
            <li><a href="/issue/index/to_me"><i class="glyphicon glyphicon-folder-close"></i> 我负责的</a></li>
            <li><a href="/issue/from_me"><i class="glyphicon glyphicon-folder-close"></i> 我创建的</a></li>
          </ul>
        </div><!-- col-sm-3 -->
        <div class="col-sm-9 col-lg-10">
      <?php if ($row['status'] == '-1') { ?>
      <div class="alert alert-warning">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <strong>抱歉~</strong> 该任务已被删除.
      </div>
      <?php } ?>
      <div class="panel panel-default">
        <div class="panel-heading">
          <div class="pull-right">
            <div class="btn-group mr10">
                <?php if(in_array($this->input->cookie('username'), $row['watch'])){ ?>
                <a href="javascript:;" id="unwatch" issueid="<?php echo $row['id']; ?>" class="btn btn-sm btn-white"><i class="glyphicon glyphicon-eye-open"></i> 已关注(<?php echo count($row['watch']); ?>)</a>
                <a href="javascript:;" id="watch" style="display: none;" issueid="<?php echo $row['id']; ?>" class="btn btn-sm btn-white"><i class="glyphicon glyphicon-eye-open"></i> 关注(<?php echo (count($row['watch']) - 1); ?>)</a>
                <?php }else{ ?>
                <a href="javascript:;" id="watch" issueid="<?php echo $row['id']; ?>" class="btn btn-sm btn-white"><i class="glyphicon glyphicon-eye-open"></i> 关注(<?php echo count($row['watch']); ?>)</a>
                <a href="javascript:;" id="unwatch" style="display: none;" issueid="<?php echo $row['id']; ?>" class="btn btn-sm btn-white"><i class="glyphicon glyphicon-eye-open"></i> 已关注(<?php echo (count($row['watch']) + 1); ?>)</a>
                <?php } ?>
                <a href="/issue/edit/<?php echo $row['id'];?>" class="btn btn-sm btn-white"><i class="fa fa-pencil mr5"></i> 编辑</a>
                <a href="javascript:;" id="del" reposid="<?php echo $row['id'];?>" class="btn btn-sm btn-white"><i class="fa fa-trash-o mr5"></i> 删除</a>
            </div>
          </div>
          <h5 class="bug-key-title"><?php if ($row['type'] == 2) {?><i class="fa fa-bug tooltips" data-toggle="tooltip" title="BUG"></i><?php } ?><?php if ($row['type'] == 1) {?><i class="fa fa-magic tooltips" data-toggle="tooltip" title="TASK"></i><?php } ?> ISSUE-<?php echo $row['id'];?></h5>
          <div class="panel-title"><?php if ($row['level']) { ?><?php echo "<strong style='color:#ff0000;'>".$level[$row['level']]['name']."</strong> ";?><?php } ?><?php if ($row['status'] == '-1') { ?><s><?php echo $row['issue_name'];?></s><?php } else { ?><?php echo $row['issue_name'];?><?php } ?> <?php if ($row['resolve']) { ?> <span class="label label-success">已解决</span><?php }?> <?php if ($row['status'] == 0) {?> <span class="label label-default">已关闭</span><?php }?></div>
        </div>
        <div class="panel-body">
          <h5 class="subtitle subtitle-lined">进度</h5>
          <div class="table-responsive">
          <table class="table table-bordered table-striped">
            <tbody>
              <tr>
                <td>
                  <?php if ($acceptUsers && isset($acceptUsers['1'])) { ?>
                  <span class="face"><img alt="" src="/static/avatar/<?php echo $users[$acceptUsers['1']['accept_user']]['username'];?>.jpg" align="absmiddle" title=""></span> <a href="/conf/profile/<?php echo $acceptUsers['1']['accept_user'];?>" target="_blank"><?php echo $users[$acceptUsers['1']['accept_user']]['realname'];?></a>
                  <?php } else { echo 'N/A'; } ?>
                </td>
                <td colspan="<?php if ($bug_total_rows) {echo 4;}else{echo 2;}?>">
                  <?php if ($acceptUsers && isset($acceptUsers['2'])) { ?>
                  <span class="face"><img alt="" src="/static/avatar/<?php echo $users[$acceptUsers['2']['accept_user']]['username'];?>.jpg" align="absmiddle" title=""></span> <a href="/conf/profile/<?php echo $acceptUsers['1']['accept_user'];?>" target="_blank"><?php echo $users[$acceptUsers['2']['accept_user']]['realname'];?></a>
                  <?php } else { echo 'N/A'; } ?>
                </td>
                <td colspan="2">
                  <?php if ($acceptUsers && isset($acceptUsers['3'])) { ?>
                  <span class="face"><img alt="" src="/static/avatar/<?php echo $users[$acceptUsers['3']['accept_user']]['username'];?>.jpg" align="absmiddle" title=""></span> <a href="/conf/profile/<?php echo $acceptUsers['3']['accept_user'];?>" target="_blank"><?php echo $users[$acceptUsers['3']['accept_user']]['realname'];?></a>
                  <?php } else { echo 'N/A'; } ?>
                </td>
                <td>
                  <?php if ($acceptUsers && isset($acceptUsers['4'])) { ?>
                  <span class="face"><img alt="" src="/static/avatar/<?php echo $users[$acceptUsers['4']['accept_user']]['username'];?>.jpg" align="absmiddle" title=""></span> <a href="/conf/profile/<?php echo $acceptUsers['4']['accept_user'];?>" target="_blank"><?php echo $users[$acceptUsers['4']['accept_user']]['realname'];?></a>
                  <?php } else { echo 'N/A'; } ?>
                </td>
              </tr>
              <tr>
                <td class="blue" width="150px">新建</td>
                <!-- #开发-我要开发# -->
                <?php if ($row['workflow'] >= 1) {?>
                <td class="blue">开发中</td>
                <?php } elseif ($row['accept_user'] == $this->input->cookie('uids')) {?>
                <td style="text-align:center;" id="td-dev"><a href="javascript:;" ids="<?php echo $row['id']; ?>" class="label label-danger dev">我要开发</a></td>
                <?php } else { ?>
                <td style="text-align:center;">开发中</td>
                <?php }?>
                <!-- #开发-开发完毕# -->
                <?php if ($row['workflow'] >= 2) {?>
                <td class="blue">开发完毕</td>
                <?php } else {?>
                <?php if ($row['workflow']  == 1 && $row['accept_user'] == $this->input->cookie('uids')) {?>
                <td style="text-align:center;" width="200px" id="td-over">
                  <a href="/test/add/<?php echo $row['id'];?>" class="label label-danger" target="_blank">提交代码</a> 
                  <a href="javascript:;" ids="<?php echo $row['id']; ?>" class="label label-primary over">提交完毕</a>
                </td>
                <?php } else {?>
                <td style="text-align:center;">开发完毕</td>
                <?php } ?>
                <?php } ?>
                <!-- #开发-修复中# -->
                <?php if ($bug_total_rows) {?>
                <?php if ($row['workflow'] >= 3) {?>
                <td class="blue">修复中</td>
                <?php } else {?>
                <td style="text-align:center;">修复中</td>
                <?php } ?>

                <?php if ($row['workflow'] >= 4) {?>
                <td class="blue">修复完毕</td>
                <?php } else {?>
                <?php if ($row['workflow'] == 3 && $acceptUsers && isset($acceptUsers['2']) && $acceptUsers['2']['accept_user'] == $this->input->cookie('uids')) { ?>
                <td style="text-align:center;" width="200px" id="td-fix">
                  <a href="/test/add/<?php echo $row['id'];?>" class="label label-danger" target="_blank">提交代码</a> 
                  <a href="javascript:;" ids="<?php echo $row['id']; ?>" class="label label-primary fix">修复完毕</a>
                </td>
                <?php }else { ?>
                <td style="text-align:center;">修复完毕</td>
                <?php } ?>
                <?php } ?>
                <?php } ?>

                <!-- #测试-测试中# -->
                <?php if ($row['workflow'] >= 5) {?>
                <td class="blue">测试中</td>
                <?php } else {?>
                <?php if (($row['workflow'] == 2 || $row['workflow'] == 4)&& $acceptUsers && isset($acceptUsers['3']) && $acceptUsers['3']['accept_user'] == $this->input->cookie('uids')) {?>
                <td style="text-align:center;" id="td-test"><a href="javascript:;" ids="<?php echo $row['id']; ?>" class="label label-danger test">我要测试</a></td>
                <?php } elseif ($row['workflow'] == 2 && $acceptUsers && !isset($acceptUsers['3']) && $acceptUsers['2']['accept_user'] == $this->input->cookie('uids')) {?>
                <td style="text-align:center;"><a href="javascript:;" id="test_user" data-type="select2" data-value="0" data-title="指定受理人"></a></td>
                <?php } else {?>
                <td style="text-align:center;">测试中</td>
                <?php } ?>
                <?php } ?>

                <!-- #测试-测试通过# -->
                <?php if ($row['workflow'] >= 6) { ?>
                  <td class="blue">测试通过</td>
                <?php } else { ?>
                  <?php if (($row['workflow'] >=3 && $row['workflow'] <= 5) && $acceptUsers && isset($acceptUsers['3']) && $acceptUsers['3']['accept_user'] == $this->input->cookie('uids')) {?>
                  <td style="text-align:center;" width="200px" id="td-wait">
                    <a href="/bug/add/<?php echo $row['id'];?>" class="label label-danger" target="_blank">反馈BUG</a> 
                    <a href="javascript:;" ids="<?php echo $row['id']; ?>" class="label label-primary waits">测试通过</a>
                  </td>
                  <?php } else {?>
                  <td style="text-align:center;">测试通过</td>
                  <?php } ?>
                <?php } ?>

                <!-- #上线# -->
                <?php if ($row['workflow'] == 7) { ?>
                <td class="blue">已上线</td>
                <?php } else { ?>
                <?php if ($row['workflow'] == 6 && $acceptUsers && isset($acceptUsers['4']) && $acceptUsers['4']['accept_user'] == $this->input->cookie('uids')) {?>
                <td style="text-align:center;" id="td-online"><a href="javascript:;" ids="<?php echo $row['id']; ?>" class="label label-danger onlines">通知上线</a></td>
                <?php } elseif ($row['workflow'] == 6 && $acceptUsers && !isset($acceptUsers['4']) && $acceptUsers['3']['accept_user'] == $this->input->cookie('uids')) {?>
                <td style="text-align:center;"><a href="javascript:;" id="test_user" data-type="select2" data-value="0" data-title="指定受理人"></a></td>
                <?php } else {?>
                <td style="text-align:center;">上线</td>
                <?php } ?>
                <?php } ?>

              </tr>
            </tbody>
          </table>
          </div><!-- table-responsive -->
          <br />
          <h5 class="subtitle subtitle-lined">描述</h5>
          <p><?php echo $row['issue_summary'];?></p>
          <br />
          <h5 class="subtitle subtitle-lined">开发信息 <span class="badge badge-info"><?php echo $total_rows;?></span></h5>
          <div class="table-responsive">
            <table class="table table-hover table-striped">
              <tbody>
                <?php
                  if ($test) {
                    foreach ($test as $value) {
                ?>
                <tr id="tr-<?php echo $value['id'];?>">
                 <td><?php echo $value['id'];?></td>
                  <td><?php if ($value['status'] == '-1') { echo '<s><a title="'.$repos[$value['repos_id']]['repos_url'].'" href="/test/repos/'.$value['repos_id'].'">'.$repos[$value['repos_id']]['repos_name'].'</a></s>'; } else { echo '<a title="'.$repos[$value['repos_id']]['repos_url'].'" href="/test/repos/'.$value['repos_id'].'">'.$repos[$value['repos_id']]['repos_name'].'</a>'; }?></span>
                  </td>
                  <td>@<?php echo $value['test_flag'];?></td>
                  <td>
                    <?php if ($value['rank'] == 0) {?>
                    <button class="btn btn-default btn-xs"><i class="fa fa-coffee"></i> 开发环境</button>
                    <?php } ?>
                    <?php if ($value['rank'] == 1) {?>
                    <button class="btn btn-primary btn-xs"><?php if ($value['state'] == 5) { ?><i class="fa fa-exclamation-circle"></i> <s>测试环境</s><?php } else {?><i class="fa fa-check-circle"></i> 测试环境<?php } ?></button>
                    <?php } ?>
                    <?php if ($value['rank'] == 2) {?>
                    <button class="btn btn-success btn-xs"><i class="fa fa-check-circle"></i> 生产环境</button>
                    <?php } ?>
                  </td>
                  <td>
                    <?php if ($value['state'] == 0) {?>
                    <button class="btn btn-default btn-xs"><i class="fa fa-coffee"></i> 待测</button>
                    <?php } ?>
                    <?php if ($value['state'] == 1) {?>
                    <button class="btn btn-primary btn-xs"><i class="fa fa-clock-o"></i> 测试中…</button>
                    <?php } ?>
                    <?php if ($value['state'] == -3) {?>
                    <button class="btn btn-danger btn-xs"><i class="fa fa-exclamation-circle"></i> 不通过</button>
                    <?php } ?>
                    <?php if ($value['state'] == 3) {?>
                    <button class="btn btn-success btn-xs"><i class="fa fa-check-circle"></i> 通过</button>
                    <?php } ?>
                    <?php if ($value['state'] == 5) {?>
                    <button class="btn btn-success btn-xs"><i class="fa fa-exclamation-circle"></i> 已被后续版本覆盖</button>
                    <?php } ?>
                  </td>
                  <td class="table-action">
                    <?php if ($value['status'] == 1) {?>
                    <div class="btn-group">
                      <button type="button" class="btn btn-xs btn-primary">更改提测状态</button>
                      <button type="button" class="btn btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                      </button>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="javascript:;" class="wait" testid="<?php echo $value['id']?>">我暂时不测了</a></li>
                        <li><a href="javascript:;" class="zhanyong" testid="<?php echo $value['id']?>">我要占用测试环境</a></li>
                        <li><a href="javascript:;" class="pass" testid="<?php echo $value['id']?>">测试不通过</a></li>
                        <li><a href="javascript:;" class="launch" testid="<?php echo $value['id']?>">测试通过待上线</a></li>
                        <li><a href="javascript:;" class="online" testid="<?php echo $value['id']?>">代码已上线</a></li>
                      </ul>
                    </div>
                    <button class="btn btn-white btn-xs deploy" ids="<?php echo $value['id'];?>">查看部署代码</button>
                    <?php if ($row['status'] == 1) {?>
                    <?php if ($value['tice'] < 1) {?>
                    <a class="btn btn-white btn-xs" href="/test/edit/<?php echo $row['id'];?>/<?php echo $value['id'];?>"><i class="fa fa-pencil"></i> 编辑</a>
                    <a class="btn btn-white btn-xs delete-row" href="javascript:;" issueid="<?php echo $row['id'];?>" testid="<?php echo $value['id'];?>"><i class="fa fa-trash-o"></i> 删除</a>
                    <?php }?>
                    <?php }?> 
                    <?php }?>
                  </td>
                </tr>
                <tr><td colspan="6" style="padding-left:0px;padding-right:0px;"><div class="abc" id="deploy-<?php echo $value['id'];?>"><?php $text = ''; if($repos[$value['repos_id']]['merge'] == 1) { $text = "cd ~/cap_scripts/" . $repos[$value['repos_id']]['repos_name'] . "/ && cap staging deploy br=" . $value['br'] . " rev=" . $value['test_flag'] . " issue=" . $row['id'];}elseif($value['repos_id'] == 42){$text = "cd ~/cap_scripts/" . $repos[$value['repos_id']]['repos_name'] . "/ && cap staging deploy rev=" . $value['test_flag'] . " issue=" . $row['id'];} if(isset($text) && !empty($text)){echo "<input type='text' value='" . $text . "'  class=\"form-control\">"; } ?></div></td></tr>
                <?php
                    }
                  } else {
                ?>
                <tr><td align="center">无提测信息</td></tr>
                <?php } ?>
              </tbody>
            </table>
            </div><!-- table-responsive -->
          <h5 class="subtitle subtitle-lined">信息</h5>
          <div class="table-responsive">
          <table class="table table-striped mb30">
            <tbody>
              <tr>
                <td width="100px">创建人</td>
                <td><?php echo $row['add_user'] ? '<a href="/conf/profile/'.$row['add_user'].'">'.$users[$row['add_user']]['realname'].'</a>' : '-';?></td>
                <td width="100px">创建时间</td>
                <td><?php echo $row['add_time'] ? date("Y/m/d H:i:s", $row['add_time']) : '-';?></td>
              </tr>
              <tr>
                <td width="100px">当前受理人</td>
                <td><a href="javascript:;" id="country" data-type="select2" data-value="<?php echo $row['accept_user'];?>" data-title="更改受理人"></a></td>
                <td width="100px">受理时间</td>
                <td><?php echo $row['last_time'] ? date("Y/m/d H:i:s", $row['last_time']) : '-';?></td>
              </tr>
              <tr>
                <td width="100px">最后修改人</td>
                <td><?php echo $row['last_user'] ? '<a href="/conf/profile/'.$row['last_user'].'">'.$users[$row['last_user']]['realname'].'</a>' : '-';?></td>
                <td width="120px">最后修改时间</td>
                <td><?php echo $row['last_time'] ? date("Y/m/d H:i:s", $row['last_time']) : '-';?></td>
              </tr>
              <tr>
                <td width="100px">所属计划</td>
                <td><?php if ($plan) { echo '<a href="/plan?planId='.$plan['id'].'" target="_blank">'.$plan['plan_name'].'</a>'; }?></td>
                <td width="120px">贡献者</td>
                <td>
                  <?php if ($acceptUsers) {
                    foreach ($acceptUsers as $key => $value) {
                      echo ' <a href="/conf/profile/'.$value['accept_user'].'">'.$users[$value['accept_user']]['realname'].'</a>';
                    }
                  }?>
                </td>
              </tr>
              <tr>
                <td width="100px">相关链接</td>
                <td>
                  <?php
                  if ($row['url']) {
                    if (strrpos($row['url'], '{')) {
                     $url = unserialize($row['url']);
                      foreach ($url as $key => $value) {
                        echo "<a href=\"".$value."\" target=\"_blank\">链接".($key+1)."</a> ";
                      }
                    } else {
                      echo "<a href=\"".$row['url']."\" target=\"_blank\">链接</a>";
                    }
                  }
                  ?>
                </td>
                <td width="120px">标签</td>
                <td>-</td>
              </tr>
            </tbody>
          </table>
          </div><!-- table-responsive -->
          <?php if ($bug_total_rows) {?>
          <h5 class="subtitle subtitle-lined">发现的BUG</h5>
          <div class="table-responsive">
            <table class="table table-striped">
              <tbody>
                <?php
                  if ($bug) {
                    foreach ($bug as $value) {
                ?>
                  <tr>
                    <td width="50px"><?php echo $value['id']?></td>
                    <td width="50px"><i class="fa fa-bug tooltips" data-toggle="tooltip" title="Bug"></i></td>
                    <td width="50px">
                      <a href="/conf/profile/<?php echo $value['accept_user'];?>" class="pull-left" target="_blank">
                        <div class="face"><img alt="" src="/static/avatar/<?php echo $users[$value['accept_user']]['username']?>.jpg" align="absmiddle" title="当前受理人：<?php echo $users[$value['accept_user']]['realname'];?>"></div>
                      </a>
                    </td>
                    <td><?php if ($value['level']) { ?><?php echo "<strong style='color:#ff0000;'>".$level[$value['level']]['name']."</strong> ";?><?php } ?><a href="/bug/view/<?php echo $value['id'];?>" target="_blank"><?php echo $value['subject']?></a></td>
                    
                    <td width="80px"><?php if ($value['state'] === '0') {?>
                    <span class="label label-default">未确认</span>
                    <?php } ?>
                    <?php if ($value['state'] === '1') {?>
                    <span class="label label-primary">处理中</span>
                    <?php } ?>
                    <?php if ($value['state'] === '3') {?>
                    <span class="label label-success">已处理</span>
                    <?php } ?>
                    <?php if ($value['state'] === '-1') {?>
                    <span class="label label-default">反馈无效</span>
                    <?php } ?>
                    </td>
                  </tr>
                  <?php
                      }
                    } else {
                  ?>
                  <tr><td colspan="6" align="center">无提测信息</td></tr>
                  <?php } ?>
              </tbody>
            </table>
          </div><!-- table-responsive -->
          <?php } ?>
        </div>
      </div>

      <div class="panel">
        <div class="panel-body">
          <?php
            if ($comment) {
              foreach ($comment as $value) {
          ?>
          <div class="media" id="comment-<?php echo $value['id'];?>">
            <div class="pull-left">
              <div class="face"><img alt="" src="/static/avatar/<?php echo $users[$value['add_user']]['username']?>.jpg" align="absmiddle" title="<?php echo $users[$value['add_user']]['realname'];?>"></div>
            </div>
            <div class="media-body">
              <span class="media-meta pull-right"><?php echo friendlydate($value['add_time']);?><?php if ($value['add_user'] == $this->input->cookie('uids')) {?><br /><a class="del" ids="<?php echo $value['id'];?>" href="javascript:;">删除</a><?php } ?></span>
              <h6 class="text-muted"><?php echo $users[$value['add_user']]['realname'];?></h6>
              <small class="text-muted"><?php if ($value['add_user'] == $row['accept_user']) { echo '当前受理人'; } else { echo '路人甲'; }?></small>
              <p><?php echo $value['content'];?></p>
            </div>
          </div>
          <?php
              }
            }
          ?>
          <div id="box"></div>
          <div class="media">
            <div class="pull-left">
              <div class="face"><img alt="" src="/static/avatar/<?php echo $users[$this->input->cookie('uids')]['username']?>.jpg" align="absmiddle" title="<?php echo $users[$this->input->cookie('uids')]['realname'];?>"></div>
            </div>
            <div class="media-body">
              <textarea id="content" name="content"></textarea>
              <div class="mb10"></div>
              <input type="hidden" value="<?php echo $row['id'];?>" id="issue_id" name="issue_id">
              <button class="btn btn-primary" id="btnSubmit">提交</button>
            </div>
          </div>
        </div><!-- row -->  
      </div><!-- panel-body -->
    </div><!-- panel -->
  </div>  
</div><!-- contentpanel -->
</div><!-- mainpanel -->
  
</section>

<div class="modal fade bs-example-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button aria-hidden="true" data-dismiss="modal" class="close" type="button">&times;</button>
            <h4 class="modal-title">提测详情</h4>
        </div>
        <div class="modal-body"><div class="modal-body-inner"></div></div>
    </div>
  </div>
</div>

<script src="/static/js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="/static/simditor-2.3.6/scripts/module.js"></script>
<script type="text/javascript" src="/static/simditor-2.3.6/scripts/uploader.js"></script>
<script type="text/javascript" src="/static/simditor-2.3.6/scripts/hotkeys.js"></script>
<script type="text/javascript" src="/static/simditor-2.3.6/scripts/simditor.js"></script>
<script src="/static/js/jquery-migrate-1.2.1.min.js"></script>
<script src="/static/js/bootstrap.min.js"></script>
<script src="/static/js/modernizr.min.js"></script>
<script src="/static/js/jquery.sparkline.min.js"></script>
<script src="/static/js/toggles.min.js"></script>
<script src="/static/js/jquery.cookies.js"></script>

<script src="/static/js/jquery.datatables.min.js"></script>
<script src="/static/js/select2.min.js"></script>
<script src="/static/js/jquery.gritter.min.js"></script>
<script src="/static/js/select2.min.js"></script>
<script src="/static/js/bootstrap-editable.min.js"></script>
<script src="/static/js/bootstrap-datetimepicker.min.js"></script>
<script src="/static/js/moment.js"></script>
<script src="/static/js/jquery.countdown.js"></script>

<script src="/static/js/custom.js"></script>
<script>
  function changeIssueStatus(obj1,obj2,obj3) {
    $(obj1).click(function(){
      var c = confirm(obj3);
      if(c) {
        id = $(this).attr("reposid");
        $.ajax({
          type: "GET",
          url: "/issue/"+obj2+"/"+id,
          dataType: "JSON",
          success: function(data){
            if (data.status) {
              jQuery.gritter.add({
                title: '提醒',
                text: data.message,
                  class_name: 'growl-success',
                  image: '/static/images/screen.png',
                sticky: false,
                time: ''
              });
              setTimeout(function(){
                location.href = data.url;
              }, 2000);
            } else {
              jQuery.gritter.add({
                title: '提醒',
                text: data.message,
                  class_name: 'growl-danger',
                  image: '/static/images/screen.png',
                sticky: false,
                time: ''
              });
            };
          }
        });
      }
    });
  }

  function changeTestStatus(obj1,obj2,obj3) {
    $(obj1).click(function(){
      var c = confirm(obj3);
      if(c) {
        id = $(this).attr("testid");
        $.ajax({
          type: "GET",
          url: "/test/"+obj2+"/"+id,
          dataType: "JSON",
          success: function(data){
            if (data.status) {
              jQuery.gritter.add({
                title: '提醒',
                text: data.message,
                  class_name: 'growl-success',
                  image: '/static/images/screen.png',
                sticky: false,
                time: ''
              });
              setTimeout(function(){
                location.href = data.url;
              }, 2000);
            } else {
              jQuery.gritter.add({
                title: '提醒',
                text: data.message,
                  class_name: 'growl-danger',
                  image: '/static/images/screen.png',
                sticky: false,
                time: ''
              });
            };
          }
        });
      }
    });
  }

  $(document).ready(function(){

    $('#deadline').countdown('<?php echo date("Y-m-d H:i", $row['deadline']);?>', function(event) {
      $(this).html(event.strftime('%D days %H:%M:%S'));
    });

    $("#del").click(
      changeIssueStatus('#del','del','确认要删除吗？')
    );
    $("#close").click(
      changeIssueStatus('#close','close','确认要关闭吗？')
    );
    $("#resolve").click(
      changeIssueStatus('#resolve','resolve','确认验证通过并告知任务添加人吗？')
    );
    $(".zhanyong").click(function(){
      var c = confirm('确认要改为测试状态吗？');
      if(c) {
        id = $(this).attr("testid");
        $.ajax({
          type: "GET",
          url: "/test/change_tice/"+id+"/zhanyong",
          dataType: "JSON",
          success: function(data){
            if (data.status) {
              jQuery.gritter.add({
                title: '提醒',
                text: data.message,
                  class_name: 'growl-success',
                  image: '/static/images/screen.png',
                sticky: false,
                time: ''
              });
              setTimeout(function(){
                location.href = data.url;
              }, 2000);
            } else {
              jQuery.gritter.add({
                title: '提醒',
                text: data.message,
                  class_name: 'growl-danger',
                  image: '/static/images/screen.png',
                sticky: false,
                time: ''
              });
            };
          }
        });
      }
    });
    $(".online").click(function(){
      var c = confirm('确认改为上线状态吗？');
      if(c) {
        id = $(this).attr("testid");
        $.ajax({
          type: "GET",
          url: "/test/change_tice/"+id+"/online",
          dataType: "JSON",
          success: function(data){
            if (data.status) {
              jQuery.gritter.add({
                title: '提醒',
                text: data.message,
                  class_name: 'growl-success',
                  image: '/static/images/screen.png',
                sticky: false,
                time: ''
              });
              setTimeout(function(){
                location.href = data.url;
              }, 2000);
            } else {
              jQuery.gritter.add({
                title: '提醒',
                text: data.message,
                  class_name: 'growl-danger',
                  image: '/static/images/screen.png',
                sticky: false,
                time: ''
              });
            };
          }
        });
      }
    });
    $(".wait").click(function(){
      var c = confirm('你确定不测了，将测试环境让给他人吗？');
      if(c) {
        id = $(this).attr("testid");
        $.ajax({
          type: "GET",
          url: "/test/change_tice/"+id+"/wait",
          dataType: "JSON",
          success: function(data){
            if (data.status) {
              jQuery.gritter.add({
                title: '提醒',
                text: data.message,
                  class_name: 'growl-success',
                  image: '/static/images/screen.png',
                sticky: false,
                time: ''
              });
              setTimeout(function(){
                location.href = data.url;
              }, 2000);
            } else {
              jQuery.gritter.add({
                title: '提醒',
                text: data.message,
                  class_name: 'growl-danger',
                  image: '/static/images/screen.png',
                sticky: false,
                time: ''
              });
            };
          }
        });
      }
    });
    $(".pass").click(function(){
      var c = confirm('你确定不测了，将测试环境让给他人吗？');
      if(c) {
        id = $(this).attr("testid");
        $.ajax({
          type: "GET",
          url: "/test/change_tice/"+id+"/pass",
          dataType: "JSON",
          success: function(data){
            if (data.status) {
              jQuery.gritter.add({
                title: '提醒',
                text: data.message,
                  class_name: 'growl-success',
                  image: '/static/images/screen.png',
                sticky: false,
                time: ''
              });
              setTimeout(function(){
                location.href = data.url;
              }, 2000);
            } else {
              jQuery.gritter.add({
                title: '提醒',
                text: data.message,
                  class_name: 'growl-danger',
                  image: '/static/images/screen.png',
                sticky: false,
                time: ''
              });
            };
          }
        });
      }
    });

    $(".launch").click(function(){
      var c = confirm('你确定要更改成测试通过待上线吗？');
      if(c) {
        id = $(this).attr("testid");
        $.ajax({
          type: "GET",
          url: "/test/change_tice/"+id+"/launch",
          dataType: "JSON",
          success: function(data){
            if (data.status) {
              jQuery.gritter.add({
                title: '提醒',
                text: data.message,
                  class_name: 'growl-success',
                  image: '/static/images/screen.png',
                sticky: false,
                time: ''
              });
              setTimeout(function(){
                location.href = data.url;
              }, 2000);
            } else {
              jQuery.gritter.add({
                title: '提醒',
                text: data.message,
                  class_name: 'growl-danger',
                  image: '/static/images/screen.png',
                sticky: false,
                time: ''
              });
            };
          }
        });
      }
    });

    $(".panel-edit").click(function(){
      var c = confirm('你确定要打开已经关闭的任务吗？');
      if(c) {
        id = $(this).attr("reposid");
        $.ajax({
          type: "GET",
          url: "/issue/open/"+id,
          dataType: "JSON",
          success: function(data){
            if (data.status) {
              jQuery.gritter.add({
                title: '提醒',
                text: data.message,
                  class_name: 'growl-success',
                  image: '/static/images/screen.png',
                sticky: false,
                time: ''
              });
              setTimeout(function(){
                location.href = data.url;
              }, 2000);
            } else {
              jQuery.gritter.add({
                title: '提醒',
                text: data.message,
                  class_name: 'growl-danger',
                  image: '/static/images/screen.png',
                sticky: false,
                time: ''
              });
            };
          }
        });
      }
    });

    $(".tice").click(function(){
      $(this).attr("disabled", true);
      id = $(this).attr("testid");
      $.ajax({
        type: "GET",
        url: "/test/tice/"+id,
        dataType: "JSON",
        success: function(data){
          if (data.status) {
            jQuery.gritter.add({
              title: '提醒',
              text: data.message,
                class_name: 'growl-success',
                image: '/static/images/screen.png',
              sticky: false,
              time: ''
            });
            setTimeout(function(){
              location.href = data.url;
            }, 2000);
          } else {
            jQuery.gritter.add({
              title: '提醒',
              text: data.message,
                class_name: 'growl-danger',
                image: '/static/images/screen.png',
              sticky: false,
              time: ''
            });
            setTimeout(function(){
              location.href = data.url;
            }, 2000);
          };
        }
      });
    });

    //发布到生产环境
    $(".cap_production").click(function(){
      $(this).attr("disabled", true);
      id = $(this).attr("testid");
      $.ajax({
        type: "GET",
        url: "/test/cap_production/"+id,
        dataType: "JSON",
        success: function(data){
          if (data.status) {
            jQuery.gritter.add({
              title: '提醒',
              text: data.message,
                class_name: 'growl-success',
                image: '/static/images/screen.png',
              sticky: false,
              time: ''
            });
            setTimeout(function(){
              location.href = data.url;
            }, 2000);
          } else {
            jQuery.gritter.add({
              title: '提醒',
              text: data.message,
                class_name: 'growl-danger',
                image: '/static/images/screen.png',
              sticky: false,
              time: ''
            });
            setTimeout(function(){
              location.href = data.url;
            }, 2000);
          };
        }
      });
    });

    $(".delete-row").click(function(){
      var c = confirm("确认要删除吗？");
      if(c) {
        testid = $(this).attr("testid");
        issueid = $(this).attr("issueid");
        $.ajax({
          type: "GET",
          url: "/test/del/"+testid+"/"+issueid,
          dataType: "JSON",
          success: function(data){
            if (data.status) {
              $("#tr-"+testid).fadeOut(function(){
                $("#tr-"+testid).remove();
              });
              return false;
            } else {
              jQuery.gritter.add({
                title: '提醒',
                text: data.message,
                  class_name: 'growl-danger',
                  image: '/static/images/screen.png',
                sticky: false,
                time: ''
              });
            };
          }
        });
      }
    });

    // Select 2 (dropdown mode)
    var countries = [];
    $.each({<?php foreach($users as $val) { ?>"<?php echo $val['uid'];?>": "<?php echo $val['realname'];?>",<?php } ?> }, function(k, v) {
        countries.push({id: k, text: v});
    });

    //指定测试人员
    jQuery('#test_user').editable({
        inputclass: 'sel-xs',
        source: countries,
        type: 'text',
        pk: 1,
        ajaxOptions: {
          type: 'GET'
        },
        url: '/issue/change_accept/<?php echo $row["id"];?>',
        send: 'always',
        select2: {
            width: 150,
            placeholder: '更改受理人',
            allowClear: true
        },
    });
    
    jQuery('#country').editable({
        inputclass: 'sel-xs',
        source: countries,
        type: 'text',
        pk: 1,
        ajaxOptions: {
          type: 'GET'
        },
        url: '/issue/change_accept/<?php echo $row["id"];?>',
        send: 'always',
        select2: {
            width: 150,
            placeholder: '更改受理人',
            allowClear: true
        },
    });

    jQuery('.country').editable({
        inputclass: 'sel-xs',
        source: countries,
        type: 'text',
        pk: 1,
        ajaxOptions: {
          type: 'GET'
        },
        url: '/test/change_accept',
        send: 'always',
        select2: {
            width: 150,
            placeholder: '更改受理人',
            allowClear: true
        },
    });

    $(".view").click(function(){
      id = $(this).attr("testid");
        $.ajax({
          type: "GET",
          url: "/test/view/"+id,
          success: function(data){
            $(".modal-title").text('提测说明');
            $(".modal-body-inner").removeClass('height300');
            $(".modal-body-inner").html(data);
          }
        });
    });

    $(".log").click(function(){
      id = $(this).attr("testid");
        $.ajax({
          type: "GET",
          url: "/test/log/"+id,
          success: function(data){
            $(".modal-title").text('更新日志');
            $(".modal-body-inner").addClass('height300');
            $(".modal-body-inner").html(data);
          }
        });
    });

  });
</script>

<script type="text/javascript">
$(function(){
  toolbar = [ 'title', 'bold', 'italic', 'underline', 'strikethrough',
    'color', '|', 'ol', 'ul', 'blockquote', 'code', 'table', '|',
    'link', 'image', 'hr', '|', 'indent', 'outdent' ];
  var editor = new Simditor({
    textarea : $('#content'),
    toolbar : toolbar,  //工具栏
    defaultImage : '/static/simditor-2.3.6/images/image.png', //编辑器插入图片时使用的默认图片
    upload: {
        url: '/admin/upload',
        params: {'<?php echo $this->security->get_csrf_token_name();?>':'<?php echo $this->security->get_csrf_hash();?>'}, //键值对,指定文件上传接口的额外参数,上传的时候随文件一起提交  
        fileKey: 'upload_file', //服务器端获取文件数据的参数名  
        connectionCount: 3,  
        leaveConfirm: '正在上传文件'
      }
  });

  $("#btnSubmit").click(function(){
    content = $("#content").val();
    issue_id = $("#issue_id").val();
    if (!content) {
      editor.focus();
      return false;
    }
    $.ajax({
      type: "POST",
      url: "/issue/coment_add_ajax",
      data: "content="+content+"&issue_id="+issue_id+"&<?php echo $this->security->get_csrf_token_name();?>=<?php echo $this->security->get_csrf_hash();?>",
      dataType: "JSON",
      success: function(data){
        if (data.status) {
          $("#box").append('<div class="media"><div class="pull-left"><div class="face"><img alt="" src="/static/avatar/'+data.message.username+'.jpg" align="absmiddle" title="'+data.message.realname+'"></div></div><div class="media-body"><span class="media-meta pull-right">'+data.message.addtime+'</span><h6 class="text-muted">'+data.message.realname+'</h6><small class="text-muted">'+data.message.usertype+'</small><p>'+data.message.content+'</p></div></div>');
          editor.setValue('');
        } else {
          alert('fail');
        };
      }
    });
  });

  $(".del").click(function(){
    var c = confirm('你确定要删除吗？');
      if(c) {
        id = $(this).attr("ids");
        $.ajax({
          type: "GET",
          url: "/issue/del_comment/"+id,
          dataType: "JSON",
          success: function(data){
            if (data.status) {
              setTimeout(function () {
                $("#comment-"+id).hide();
              }, 500);
            } else {
              alert('fail');
            }
          }
        });
      }
  });

  $("#watch").click(function(){
    id = $(this).attr("issueid");
    $.ajax({
      type: "GET",
          url: "/issue/watch/"+id+"/1",
      dataType: "JSON",
      success: function(data){
        if (data.status) {
            jQuery('#watch').hide();
            jQuery('#unwatch').show();
        } else {
          alert('操作失败');
        }
      }
    });
  });

  $("#unwatch").click(function(){
    id = $(this).attr("issueid");
    $.ajax({
      type: "GET",
          url: "/issue/watch/"+id+"/0",
      dataType: "JSON",
      success: function(data){
        if (data.status) {
            jQuery('#unwatch').hide();
            jQuery('#watch').show();
        } else {
          alert('操作失败');
        }
      }
    });
  });

  $('.deploy').click(function(){
    var id = $(this).attr('ids');
    var obj = "#deploy-"+id;
    if(!$(obj).hasClass('open')) {

      $(obj).addClass('open');
    }
    else
      $(obj).removeClass('open');
    return false;
  });

  //我要开发
  $(".dev").click(function(){
    $(this).attr("disabled", true);
    id = $(this).attr("ids");
    $.ajax({
      type: "GET",
      url: "/issue/change_flow/"+id+"/dev",
      dataType: "JSON",
      success: function(data){
        if (data.status) {
          $(this).hide();
          $("#td-dev").addClass('blue');
          $("#td-dev").text('开发中');
          tip(data.message, data.url, 'success', 2000);
        } else {
          tip(data.message, data.url, 'danger', 5000);
        };
      }
    });
  });

  //我要测试
  $(".test").click(function(){
    $(this).attr("disabled", true);
    id = $(this).attr("ids");
    $.ajax({
      type: "GET",
      url: "/issue/change_flow/"+id+"/test",
      dataType: "JSON",
      success: function(data){
        if (data.status) {
          $(this).hide();
          $("#td-test").addClass('blue');
          $("#td-test").text('测试中');
          tip(data.message, data.url, 'success', 2000);
        } else {
          tip(data.message, data.url, 'danger', 5000);
        };
      }
    });
  });

  //开发完毕
  $(".over").click(function(){
    var c = confirm('你确定已经完成代码信息提交了吗？');
    if(c) {
      $(this).attr("disabled", true);
      id = $(this).attr("ids");
      $.ajax({
        type: "GET",
        url: "/issue/change_flow/"+id+"/over",
        dataType: "JSON",
        success: function(data){
          if (data.status) {
            $(this).hide();
            $("#td-over").addClass('blue');
            $("#td-over").text('开发完毕');
            tip(data.message, data.url, 'success', 2000);
          } else {
            tip(data.message, data.url, 'danger', 5000);
          };
        }
      });
    }
  });

  //修复完毕
  $(".fix").click(function(){
    var c = confirm('你确定已经完成所有BUG修复并提交相应代码了吗？');
    if(c) {
      $(this).attr("disabled", true);
      id = $(this).attr("ids");
      $.ajax({
        type: "GET",
        url: "/issue/change_flow/"+id+"/fixed",
        dataType: "JSON",
        success: function(data){
          if (data.status) {
            $(this).hide();
            $("#td-fix").addClass('blue');
            $("#td-fix").text('修复完毕');
            tip(data.message, data.url, 'success', 2000);
          } else {
            tip(data.message, data.url, 'danger', 5000);
          };
        }
      });
    }
  });

  //测试通过
  $(".waits").click(function(){
    var c = confirm('你确定已经验证通过了吗？');
    if(c) {
      $(this).attr("disabled", true);
      id = $(this).attr("ids");
      $.ajax({
        type: "GET",
        url: "/issue/change_flow/"+id+"/wait",
        dataType: "JSON",
        success: function(data){
          if (data.status) {
            $(this).hide();
            $("#td-wait").addClass('blue');
            $("#td-wait").text('测试通过');
            tip(data.message, data.url, 'success', 2000);
          } else {
            tip(data.message, data.url, 'danger', 5000);
          };
        }
      });
    }
  });

  //已上线
  $(".onlines").click(function(){
    var c = confirm('你确定已经完成上线了吗？');
    if(c) {
      $(this).attr("disabled", true);
      id = $(this).attr("ids");
      $.ajax({
        type: "GET",
        url: "/issue/change_flow/"+id+"/online",
        dataType: "JSON",
        success: function(data){
          if (data.status) {
            $(this).hide();
            $("#td-online").addClass('blue');
            $("#td-online").text('已上线');
            tip(data.message, data.url, 'success', 2000);
          } else {
            tip(data.message, data.url, 'danger', 5000);
          };
        }
      });
    }
  });

});

//消息提醒通用组建配置
function tip(message, url, color, sec) {
  jQuery.gritter.add({
    title: '提醒',
    text: message,
      class_name: 'growl-'+color,
      image: '/static/images/screen.png',
    sticky: false,
    time: ''
  });
  setTimeout(function(){
    location.href = url;
  }, sec);
}
</script>

</body>
</html>

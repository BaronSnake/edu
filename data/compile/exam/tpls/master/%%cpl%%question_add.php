<?php if(!$this->tpl_var['userhash']){ ?>
<?php $this->_compileInclude('header'); ?>
<body>
<?php $this->_compileInclude('nav'); ?>
<div class="container-fluid">
	<div class="row-fluid">
		<div class="main">
			<div class="col-xs-2" style="padding-top:10px;margin-bottom:0px;">
				<?php $this->_compileInclude('menu'); ?>
			</div>
			<div class="col-xs-10" id="datacontent">
<?php } ?>
				<div class="box itembox" style="margin-bottom:0px;border-bottom:1px solid #CCCCCC;">
					<div class="col-xs-12">
						<ol class="breadcrumb">
							<li><a href="index.php?<?php echo $this->tpl_var['_app']; ?>-master"><?php echo $this->tpl_var['apps'][$this->tpl_var['_app']]['appname']; ?></a></li>
							<li><a href="index.php?<?php echo $this->tpl_var['_app']; ?>-master-questions&page=<?php echo $this->tpl_var['page']; ?><?php echo $this->tpl_var['u']; ?>">普通试题管理</a></li>
							<li class="active">添加普通试题</li>
						</ol>
					</div>
				</div>
				<div class="box itembox" style="padding-top:10px;margin-bottom:0px;">
					<h4 class="title" style="padding:10px;">
						添加普通试题
						<a class="btn btn-primary pull-right" href="index.php?<?php echo $this->tpl_var['_app']; ?>-master-questions&page=<?php echo $this->tpl_var['page']; ?><?php echo $this->tpl_var['u']; ?>">普通试题管理</a>
					</h4>
					<form action="index.php?exam-master-questions-addquestion" method="post" class="form-horizontal">
						<fieldset>
						<div class="form-group">
							<label class="control-label col-sm-2">知识点：</label>
						  	<div class="col-sm-9">
						  		<textarea class="form-control" rows="4" needle="needle" min="1" msg="您最少需要选定一个知识点" name="args[questionknowsid]" id="questionknowsid" readonly></textarea>
							</div>
						</div>
						<div class="form-group">
					  		<label class="control-label col-sm-2"></label>
					  		<div class="col-sm-9 form-inline">
                                                                <select class="combox form-control" target="issubjectseclect" refUrl="?exam-master-questions-ajax-getsubjectbygradeid&gradeid={value}">
					        		<option value="0">选择年级</option>
							  		<?php $gid = 0;
 foreach($this->tpl_var['grade'] as $key => $grade1){ 
 $gid++; ?>
							  		<option value="<?php echo $grade1['gradeid']; ?>"><?php echo $grade1['grade']; ?></option>
							  		<?php } ?>
						  		</select>
						  		<select class="combox form-control" id = "issubjectseclect" target="isectionselect" refUrl="?exam-master-questions-ajax-getsectionsbysubjectid&subjectid={value}">
					        		<option value="0">选择科目</option>
							  		{*<?php $sid = 0;
 foreach($this->tpl_var['subjects'] as $key => $subject){ 
 $sid++; ?>
							  		<option value="<?php echo $subject['subjectid']; ?>"><?php echo $subject['subject']; ?></option>
							  		<?php } ?>*}
						  		</select>
						  		<select class="combox form-control" id="isectionselect" target="iknowsselect" refUrl="?exam-master-questions-ajax-getknowsbysectionid&sectionid={value}">
						  			<option value="0">选择章节</option>
						  		</select>
						  		<select class="combox form-control" id="iknowsselect">
						  		<option value="0">选择知识点</option>
						  		</select>
							</div>
						</div>
						<div class="form-group">
					  		<label class="control-label col-sm-2"></label>
					  		<div class="col-sm-9">
					  			<input type="button" class="btn btn-primary" value="选定" onclick="javascript:setKnowsList('questionknowsid','iknowsselect','+');"/>
					  			<input type="button" class="btn btn-danger" value="清除" onclick="javascript:setKnowsList('questionknowsid','iknowsselect','-');"/>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2">题型：</label>
						  	<div class="col-sm-3">
							  	<select needle="needle" msg="您必须为要添加的试题选择一种题型" name="args[questiontype]" class="form-control" onchange="javascript:setAnswerHtml($(this).find('option:selected').attr('rel'),'answerbox');">
							  		<?php $qid = 0;
 foreach($this->tpl_var['questypes'] as $key => $questype){ 
 $qid++; ?>
							  		<option rel="<?php if($questype['questsort']){ ?>0<?php } else { ?><?php echo $questype['questchoice']; ?><?php } ?>" value="<?php echo $questype['questid']; ?>"<?php if($questype['questid'] == $this->tpl_var['question']['questiontype']){ ?> selected<?php } ?>><?php echo $questype['questype']; ?></option>
							  		<?php } ?>
							  	</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2">题干：</label>
						  	<div class="col-sm-10">
							  	<textarea class="ckeditor" name="args[question]" id="question"><?php echo $this->tpl_var['question']['question']; ?></textarea>
							  	<span class="help-block">需要填空处请以()表示。</span>
							</div>
						</div>
						<div class="form-group" id="selecttext">
							<label class="control-label col-sm-2">备选项：</label>
						  	<div class="col-sm-10">
							  	<textarea class="ckeditor" name="args[questionselect]" id="questionselect"><?php echo $this->tpl_var['question']['questionselect']; ?></textarea>
							  	<span class="help-block">无选择项的请不要填写，如填空题、问答题等主观题。</span>
							</div>
						</div>
						<div class="form-group" id="selectnumber">
							<label class="control-label col-sm-2">备选项数量：</label>
						  	<div class="col-sm-3">
							  	<select class="form-control" name="args[questionselectnumber]">
							  		<option value="0">0</option>
							  		<option value="2">2</option>
							  		<option value="3">3</option>
							  		<option value="4" selected>4</option>
							  		<option value="5">5</option>
							  		<option value="6">6</option>
							  		<option value="7">7</option>
							  		<option value="8">8</option>
							  	</select>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2">参考答案：</label>
							<div class="col-sm-10">
								<div id="answerbox_1" class="answerbox">
								  	<label class="radio-inline">
								  		<input type="radio" name="targs[questionanswer1]" value="A" checked>A
								  	</label>
								  	<label class="radio-inline">
								  		<input type="radio" name="targs[questionanswer1]" value="B">B
								  	</label>
								  	<label class="radio-inline">
								  		<input type="radio" name="targs[questionanswer1]" value="C">C
								  	</label>
								  	<label class="radio-inline">
								  		<input type="radio" name="targs[questionanswer1]" value="D">D
								  	</label>
								  	<label class="radio-inline">
								  		<input type="radio" name="targs[questionanswer1]" value="E">E
								  	</label>
								  	<label class="radio-inline">
								  		<input type="radio" name="targs[questionanswer1]" value="F">F
								  	</label>
								  	<label class="radio-inline">
								  		<input type="radio" name="targs[questionanswer1]" value="G">G
								  	</label>
								  	<label class="radio-inline">
								  		<input type="radio" name="targs[questionanswer1]" value="H">H
								  	</label>
								</div>
								<div id="answerbox_2" style="display:none;" class="answerbox">
								  	<label class="checkbox-inline">
								  		<input type="checkbox" name="targs[questionanswer2][]" value="A">A
								  	</label>
								  	<label class="checkbox-inline">
								  		<input type="checkbox" name="targs[questionanswer2][]" value="B">B
								  	</label>
								  	<label class="checkbox-inline">
								  		<input type="checkbox" name="targs[questionanswer2][]" value="C">C
								  	</label>
								  	<label class="checkbox-inline">
								  		<input type="checkbox" name="targs[questionanswer2][]" value="D">D
								  	</label>
								  	<label class="checkbox-inline">
								  		<input type="checkbox" name="targs[questionanswer2][]" value="E">E
								  	</label>
								  	<label class="checkbox-inline">
								  		<input type="checkbox" name="targs[questionanswer2][]" value="F">F
								  	</label>
								  	<label class="checkbox-inline">
								  		<input type="checkbox" name="targs[questionanswer2][]" value="G">G
								  	</label>
								  	<label class="checkbox-inline">
								  		<input type="checkbox" name="targs[questionanswer2][]" value="H">H
								  	</label>
								</div>
								<div id="answerbox_3" style="display:none;" class="answerbox">
								  	<label class="checkbox-inline">
								  		<input type="checkbox" name="targs[questionanswer3][]" value="A">A
								  	</label>
								  	<label class="checkbox-inline">
								  		<input type="checkbox" name="targs[questionanswer3][]" value="B">B
								  	</label>
								  	<label class="checkbox-inline">
								  		<input type="checkbox" name="targs[questionanswer3][]" value="C">C
								  	</label>
								  	<label class="checkbox-inline">
								  		<input type="checkbox" name="targs[questionanswer3][]" value="D">D
								  	</label>
								  	<label class="checkbox-inline">
								  		<input type="checkbox" name="targs[questionanswer3][]" value="E">E
								  	</label>
								  	<label class="checkbox-inline">
								  		<input type="checkbox" name="targs[questionanswer3][]" value="F">F
								  	</label>
								  	<label class="checkbox-inline">
								  		<input type="checkbox" name="targs[questionanswer3][]" value="G">G
								  	</label>
								  	<label class="checkbox-inline">
								  		<input type="checkbox" name="targs[questionanswer3][]" value="H">H
								  	</label>
								</div>
								<div id="answerbox_4" class="answerbox" style="display:none;">
								  	<label class="radio-inline">
								  		<input type="radio" name="targs[questionanswer4]" value="A" checked>对
								  	</label>
								  	<label class="radio-inline">
								  		<input type="radio" name="targs[questionanswer4]" value="B">错
								  	</label>
								</div>
								<div id="answerbox_5" class="answerbox" style="display:none;">
								  	<input type="text" name="targs[questionanswer5]" value="" />
								</div>
								<div id="answerbox_0" style="display:none;" class="answerbox">
							  		<textarea cols="72" rows="7" class="ckeditor" id="questionanswer0" name="targs[questionanswer0]"><?php echo $this->tpl_var['question']['questionanswer']; ?></textarea>
								</div>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2">习题解析：</label>
						  	<div class="col-sm-10">
						  		<textarea class="ckeditor" name="args[questiondescribe]" id="questiondescribe"><?php echo $this->tpl_var['question']['questiondescribe']; ?></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-sm-2">难度：</label>
						  	<div class="col-sm-3">
							  	<select class="form-control" name="args[questionlevel]" needle="needle" msg="您必须为要添加的试题设置一个难度">
							  		<option value="1"<?php if(!$this->tpl_var['question']['questionlevel']==1){ ?> selected<?php } ?>>易</option>
							  		<option value="2"<?php if(!$this->tpl_var['question']['questionlevel']==2){ ?> selected<?php } ?>>中</option>
							  		<option value="3"<?php if(!$this->tpl_var['question']['questionlevel']==3){ ?> selected<?php } ?>>难</option>
							  	</select>
							</div>
						</div>
						<div class="form-group">
						  	<label class="control-label col-sm-2"></label>
						  	<div class="col-sm-9">
							  	<button class="btn btn-primary" type="submit">提交</button>
							  	<input type="hidden" name="page" value="<?php echo $this->tpl_var['page']; ?>"/>
							  	<input type="hidden" name="insertquestion" value="1"/>
							  	<?php $aid = 0;
 foreach($this->tpl_var['search'] as $key => $arg){ 
 $aid++; ?>
								<input type="hidden" name="search[<?php echo $key; ?>]" value="<?php echo $arg; ?>"/>
								<?php } ?>
							</div>
						</div>
					</form>
				</div>
			</div>
<?php if(!$this->tpl_var['userhash']){ ?>
		</div>
	</div>
</div>
<?php $this->_compileInclude('footer'); ?>
</body>
</html>
<?php } ?>
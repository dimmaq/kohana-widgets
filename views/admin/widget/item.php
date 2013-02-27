<a href="<?=_ar('widget');?>">&larr; Назад к списку</a>

<?php
	echo Form::open('', array('class' => 'form-add-edit')),
				Form::hidden('id', Arr::get($form, 'id'));
?>
	<table class="form-table">
		<tr>
			<th colspan="2"><h3><?=$action=='add'?'Новый блок':'Редактирование блок';?></h3></th>
		</tr>
		<tr>
			<td class="form-desc">
				<label for="name">Уникальное имя<i class="form-required">*</i><br /><i class="form-hint"></i></label>
				<div class="form-error"><? echo Arr::get($errors, 'name'); ?></div>
			</td>
			<td><?=Form::input('name', Arr::get($form, 'name'), array('id' => 'name','required'=>'required'));?></td>
		</tr>
		<tr>
			<td class="form-desc">
				<label for="text">Текст</label>
				<div class="form-error"><? echo Arr::get($errors, 'text'); ?></div>
			</td>
			<td><?=Form::textarea('text',Arr::get($form, 'text'),array('class' => 'html','id'=>'text','rows' => 20,'cols' => '',));?>
			</td>
		</tr>
		<tr>
			<td colspan="2" class="form-submit">
				<? echo Form::submit('submit', 'Сохранить'); ?>
			</td>
		</tr>
	</table>
<?=Form::close();?>

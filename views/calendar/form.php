<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="name">Titre</label>
            <input id="name" type="text" required class="form-control" name="descriptionName" value="<?= isset($parameters['data']['descriptionName']) ? h($parameters['data']['descriptionName']): '';?>">
            <?php if(isset($errors['name'])):?>
                <small class="form-text text-muted"><?= $errors['name'];?></small>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="date">Date</label>
            <input id="date" type="date" required class="form-control" name="date" value="<?= isset($parameters['data']['startEvent']) ?h(date('Y-m-d', strtotime($parameters['data']['startEvent']))): '' ;?>">
            <?php if(isset($errors['date'])):?>
                <small class="form-text text-muted"><?= $errors['date'];?></small>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label for="start">Début de l'évènement</label>
            <input id="start" type="time" required class="form-control" name="start" placeholder="HH:MM" value="<?= isset($parameters['data']['startEvent']) ? h(date('H:i', strtotime($parameters['data']['startEvent']))): '';?>">
            <?php if(isset($errors['start'])):?>
                <small class="form-text text-muted"><?= $errors['start'];?></small>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label for="end">Fin de l'évènement</label>
            <input id="end" type="time" required class="form-control" name="end" placeholder="HH:MM"value="<?= isset($parameters['data']['endEvent']) ? h(date('H:i', strtotime($parameters['data']['endEvent']))): '';?>">
        </div>
    </div>
</div>
<div class="form-group">
    <label for="description">Description</label>
    <textarea name="description" id="description" class="form-control"><?= isset($parameters['data']['description']) ? h($parameters['data']['description']): '';?></textarea>
</div>
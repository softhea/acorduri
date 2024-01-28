<h3>Tabulaturi</h3>

<?php if ($errors->any()): ?>
<div class="alert alert-warning alert-dismissable">
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<?=implode('', $errors->all('<li class="error">:message</li>'))?>
</div>
<?php endif; ?>

<?php if (Auth::check()): ?>
<form class="form-horizontal" method="post" action="">
<div class="control-group">
    <label class="control-label" for="song">Melodie</label>
    <div class="controls">
	    <input type="text" id="song" name="song" placeholder="Melodie">
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="artist">Artist</label>
    <div class="controls">
	    <input type="text" id="artist" name="artist" placeholder="Artist">
    </div>
</div>
<div class="control-group">
    <label class="control-label" for="text">Tabulatura</label>
    <div class="controls">
	    <textarea id="text" name="text" placeholder="Tabulatura" class="tab"></textarea>
    </div>
</div>


<div class="control-group">
    <div class="controls">
        <button type="submit" class="btn btn-warning">Adauga</button>
    </div>
</div>
</form>
<?php endif; ?>

<table class="table table-bordered table-striped table-hover">
	<tr>
    	<th>Melodie</th>
        <th>Artist</th>
       	<th>Utilizator</th>
       	<th>Acorduri</th>        
       	<th>Numar de acorduri</th>        
       	<th>Vizualizari</th> 
    </tr>
	<tr>
		<form action="" method="get" id="search_form" class="navbar-form navbar-left" role="search">
    	<th><input type="text" name="melodie" id="search_song" class="form-control" value="<?=$search_song?>"></th>
        <th><input type="text" name="artist" id="search_artist" class="form-control" value="<?=$search_artist?>"></th>
       	<th><input type="text" name="utilizator" id="search_user" class="form-control" value="<?=$search_user?>"></th>
       	<th><input type="text" name="acorduri" id="search_chords" class="form-control" value="<?=$search_chords?>"></th>
       	<th><input type="text" name="numar_acorduri" id="search_no_of_chords" class="form-control" value="<?=$search_no_of_chords?>"></th>      
       	<th><button class="btn btn-success" id="search_submit" type="submit">Cauta!</button></th>
		</form>
    </tr>	
<?php if (count($tabs) > 0): ?>
<?php foreach ($tabs as $tab): ?>
	<tr>
    	<td><a href="/tabulatura/<?=$tab->id?>_<?=$tab->song?>.html" ><?=$tab->song?></a></td>
       	<!--<td><a href="/artist/<? //=$tab->artist->id?>_<? //=$tab->artist->artist?>.html" ><? //=$tab->artist->artist?></a></td>-->
		<td><a href="/artist/<?=$tab->artist_id?>_<?=$tab->artist?>.html" ><?=$tab->artist?></a></td>
       	<td><a href="/utilizator/<?=$tab->username?>.html" ><?=$tab->name?></a></td>
        <td>        
        	<?php if (count($tab->chords) > 0): ?>
			<?php foreach ($tab->chords as $i => $chord): ?>
        	<a href="/acord/<?=$chord->id?>_<?=$chord->chord?>.html" class="chord" chord_id="chord_<?=$i?>"><?=$chord->chord?></a>&nbsp;
			<div id="chord_<?=$i?>" style="position: absolute; top: 0; left: 0; width: 136px; height: 173px; z-index: 9999; display: none;" ><img src="/img/chords/chord_<?=$chord['chord']?>.jpg" /></div>            
            <?php endforeach; ?>
            <?php endif; ?>
        </td>
       	<td><?=$tab->no_of_chords?></td>
       	<td><?=$tab->views?></td>
        <?php if (Auth::check() && Auth::user()->id == $tab->user_id): ?>
        <th>
        	<a href="/modifica-tabulatura/<?=$tab->id?>" class="btn btn-warning">Modifica</a>
	        <a href="/sterge-tabulatura/<?=$tab->id?>" class="btn btn-danger">Sterge</a>
        </th>                
        <?php endif; ?>        
    </tr>
<?php endforeach; ?>
<?php endif; ?>
</table>
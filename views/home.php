<p>
Users List
</p>

<ul>
    <?php foreach($users as $user) { ?>
    <li> 
        <strong> 
        <?php echo $user->id; ?>
        </strong> : 
        
        <?php echo $user->name; ?>
    </li>
    <?php } ?>
</ul>
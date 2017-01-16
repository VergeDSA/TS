        <!-- Middle Column -->
        <style>
            em.comment {
                margin-left: 4em;
            }
        </style>
        <div class="w3-col m7">

            <div class="w3-row-padding">
                <div class="w3-col m12">
                    <div class="w3-card-2 w3-round w3-white">
                        <div class="w3-container w3-padding">
                            <!--              <h6 class="w3-opacity">Social Media template by w3.css</h6>
                                          <p class="w3-border w3-padding" contenteditable="true"> New post</p>  -->
                            <button type="button" class="w3-btn w3-theme"><i class="fa fa-pencil"></i> &nbsp;New post</button>
                        </div>
                    </div>
                </div>
            </div>

            <?php foreach ($userNews as $oneUserNews): ?>
                <div class="w3-container w3-card-2 w3-white w3-round w3-margin"><br>
                    <img src="/../avatars/<?=$userAvatar->fileName?>" alt="Avatar" class="w3-left w3-circle w3-margin-right" style="width:60px">
                    <span class="w3-right w3-opacity"><?=$oneUserNews->news->published?></span>
                    <h4><?=$user->firstName?> <?=$user->lastName?></h4><br>
                    <hr class="w3-clear">
                    <p><h3><?=$oneUserNews->news->title?></h3></p>
                    <img src="/../pictures/<?=$oneUserNews->news->picture?>" style="width:100%" class="w3-margin-bottom">
                    <p><?=$oneUserNews->news->text?></p>
                    <!--          <button type="button" class="w3-btn w3-theme-d1 w3-margin-bottom"><i class="fa fa-thumbs-up"></i> &nbsp;Like</button>  -->
                    <button type="button" class="w3-btn w3-theme-d2 w3-margin-bottom"><i class="fa fa-comment"></i> &nbsp;Comment</button>
                    <p><h4>Комментарии пользователей:</h4></p>
                    <?php foreach ($oneUserNews->newsComment as $newsComment): ?>
                        <p><img src="/../avatars/<?=$newsComment->comment->user->userAvatar->fileName?>" class="w3-circle" style="height:25px;width:25px" alt="Avatar">
                            <?=$newsComment->comment->published?> пользователь <strong><?=$newsComment->comment->user->firstName?>
                            <?=$newsComment->comment->user->lastName?></strong> написал(а):<br />
                        <em class="comment"><?=$newsComment->comment->text?></em></p>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>


            <!-- End Middle Column -->
        </div>

                    <?php $options = array() ?>
                    <?php $options['bold_dog_names'] = true ?>
                    <?php $options['refer_as_you'] = false ?>
                    <div class="panel-body"><p><?= $this->userHasNDogsAndTheirNamesArePhrase($profile, array(), $options) ?></p></div>

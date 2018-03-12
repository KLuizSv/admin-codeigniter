<section class="panel">
    <header class="panel-heading">
        <?php echo $usuario['nombres'] . ' ' . $usuario['apellidos']; ?> <span class="tools pull-right">
    <a href="javascript:;" class="fa fa-chevron-down"></a>
    <a href="javascript:;" class="fa fa-cog"></a>
    <a href="javascript:;" class="fa fa-times"></a>
    </span>
    </header>
    <div class="panel-body">
        <div class="chat-conversation">
            <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 360px;"><ul class="conversation-list" style="overflow: hidden; width: auto; height: 360px;">
                <li class="clearfix">
                    <div class="chat-avatar">
                        <img src="images/chat-user-thumb.png" alt="male">
                        <i>10:00</i>
                    </div>
                    <div class="conversation-text">
                        <div class="ctext-wrap">
                            <i>John Carry</i>
                            <p>
                                Hello!
                            </p>
                        </div>
                    </div>
                </li>
                <li class="clearfix odd">
                    <div class="chat-avatar">
                        <img src="images/chat-user-thumb-f.png" alt="female">
                        <i>10:00</i>
                    </div>
                    <div class="conversation-text">
                        <div class="ctext-wrap">
                            <i>Lisa Peterson</i>
                            <p>
                                Hi, How are you? What about our next meeting?
                            </p>
                        </div>
                    </div>
                </li>
                <li class="clearfix">
                    <div class="chat-avatar">
                        <img src="images/chat-user-thumb.png" alt="male">
                        <i>10:00</i>
                    </div>
                    <div class="conversation-text">
                        <div class="ctext-wrap">
                            <i>John Carry</i>
                            <p>
                                Yeah everything is fine
                            </p>
                        </div>
                    </div>
                </li>
                <li class="clearfix odd">
                    <div class="chat-avatar">
                        <img src="images/chat-user-thumb-f.png" alt="female">
                        <i>10:00</i>
                    </div>
                    <div class="conversation-text">
                        <div class="ctext-wrap">
                            <i>Lisa Peterson</i>
                            <p>
                                Wow that's great
                            </p>
                        </div>
                    </div>
                </li>
            </ul><div class="slimScrollBar" style="width: 7px; position: absolute; top: 0px; opacity: 0.4; display: none; border-top-left-radius: 7px; border-top-right-radius: 7px; border-bottom-right-radius: 7px; border-bottom-left-radius: 7px; z-index: 99; right: 1px; height: 360px; background: rgb(0, 0, 0);"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-top-left-radius: 7px; border-top-right-radius: 7px; border-bottom-right-radius: 7px; border-bottom-left-radius: 7px; opacity: 0.2; z-index: 90; right: 1px; background: rgb(51, 51, 51);"></div></div>
            <div class="row">
                <div class="col-xs-9">
                    <input type="text" class="form-control chat-input" placeholder="Enter your text">
                </div>
                <div class="col-xs-3 chat-send">
                    <button type="submit" class="btn btn-default">Send</button>
                </div>
            </div>
        </div>
    </div>
</section>
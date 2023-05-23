<html lang="en">
<head>
  <title>Dashboard</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>
    <div class="row" style="background-color: lightcyan;">
        <div class="col-sm-6">
            @auth
                <h1> Home: {{ Auth::user()->name }} </h1>
            @else
                <h1>Guest User</h1>
            @endauth
        </div>
        <div class="col-sm-2">
            <h3> <a href="{{ url('/home') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Home</a></h3>
        </div>
            @auth
            <div class="col-sm-2">
                <h3><a href="{{ route('logout') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Logout</a></h3>
            </div>
            <div class="col-sm-2">
                <h3><a href="{{ route('update' , Auth::user()->id) }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Update profile</a></h3>
            </div>
            @else
            <div class="col-sm-2">
                <h3><a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a></h3>
            </div>
            <div class="col-sm-2">
                <h3><a href="{{ route('register') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Register</a></h3>
            </div>
            @endauth
    </div>
    <!-- @auth
        <h1> Home: {{ Auth::user()->name }} </h1>
    @else
        <p>Please log in to view this page.</p>
    @endauth  -->

    <div style="text-align: center;">
        <h3>Thread</h3>
        <form action="{{ route('add_comment') }}" method="post">
            @csrf
            <div style="display:none" id="thread">
                <textarea placeholder="Create Thread" style="height: 150px; width: 650px;" name="thread" required></textarea><br><br>
            </div>
            <button type="submit" class="btn btn-primary" onclick="create_thread(this)" style="padding: 14px 21px;border-radius: 20px;font-size: 17px;">Create Thread</button>
            <!-- <input type="submit" class="btn btn-primary" value="Create Thread" id="thread_btn"> -->
        </form>
    </div>

    <div style="padding-left: 15%;">
        <h2>All Comments</h2>
        <!-- <?php //echo '<pre>'; print_r($threads); ?> -->
        @foreach($threads as $thread)
        <div style="background-color: #e1e1d0; padding: 15px 15px;border-radius: 5%;
">
            <b>{{ $thread->name }}</b>
            <p>{!! nl2br($thread->threads) !!}</p>

            <a href="javasctipt::void(0);" onclick="replay(this)" data-threads_id="{{ $thread->id }}">comment</a>

            @foreach($comments as $comment)
                @if($comment->best_replay==NULL)
                    @if($comment->thread_id == $thread->id)
                        <div style="margin-left:3%; margin-bottom:10px;background-color:ghostwhite;width: max-content;padding: 10px 10px;border-radius: 22px;">
                            <b>{{ $comment->name }}</b>
                            <p>{!! nl2br($comment->comments) !!}</p>
                            @auth
                                @if($thread->user_id == Auth::user()->id)
                                    <a href="{{ route('best_replay', $comment->id) }}">Best Reply</a>
                                @endif
                            @endauth
                        </div>
                    @endif
                @endif
                @if($comment->best_replay==1)
                    @if($comment->thread_id == $thread->id)
                        <div style="margin-left:3%; margin-bottom:10px;background-color:#b3fff0;width: max-content;padding: 10px 10px;border-radius: 22px;">
                            <b>{{ $comment->name }}</b>
                            <p>{!! nl2br($comment->comments) !!}</p>
                            @auth
                                @if($thread->user_id == Auth::user()->id)
                                    <a href="{{ route('best_replay', $comment->id) }}">Best Reply</a>
                                @endif
                            @endauth
                        </div>
                    @endif
                @endif
            @endforeach
        </div><br>
        @endforeach

        <div style="display: none;" class="replaysec">
            <form action="{{ route('add_replay') }}" method="post">
                @csrf
                <input type="hidden" id="threads_id" name="threads_id">
                <textarea placeholder="Comment" name="replay" style="border-radius: 12px;    padding: 5px 10px;"></textarea><br>
                <input type="submit" class="btn btn-primary btn-sm" value="Comment" style="border-radius: 15px;">
                <!-- <a href="" class="btn btn-primary btn-sm" style="margin-top: 6px;"></a> -->
                <a href="javascript::void(0);" class="btn  btn-sm" style="margin-top: 6px;" onclick="replay_close(this)">Close</a>
            </form>
        </div>
    </div>




    <script type="text/javascript">
        function replay(caller){
            document.getElementById('threads_id').value=$(caller).attr('data-threads_id');
            $('.replaysec').insertAfter($(caller));
            $('.replaysec').show();
        }

        function create_thread(caller){
            // document.getElementById('threads_id').value=$(caller).attr('data-threads_id');
            // $('.replaysec').insertAfter($(caller));
            $('#thread').show();
        }

        function replay_close(caller){
            
            $('.replaysec').hide();
        }

        // Refresh Page and Keep Scroll Position

        document.addEventListener("DOMContentLoaded", function(event) { 
            var scrollpos = localStorage.getItem('scrollpos');
            if (scrollpos) window.scrollTo(0, scrollpos);
        });

        window.onbeforeunload = function(e) {
            localStorage.setItem('scrollpos', window.scrollY);
        };
    </script>


</body>
</html>
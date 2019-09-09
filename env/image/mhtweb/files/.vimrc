"**************************************************************************************
" Initial setting
"--------------------------------------------------------------------------------------

set nocompatible                                    " 必ず最初に書く
set viminfo='20,<50,s10,h,!                         " YankRing用に!を追加
set t_Co=256                                        " 256色表示
set shellslash                                      " Windowsでディレクトリパスの区切り文字に / を使えるようにする
set lazyredraw                                      " マクロなどを実行中は描画を中断
set tabstop=4 shiftwidth=4 softtabstop=0            " タブの幅、ソフトタブ
set expandtab                                       " タブを空白文字に展開
set autoindent                                      " 自動インデント，スマートインデント
set smartindent                                     " 自動インデント，スマートインデント
set backspace=indent,eol,start                      " バックスペースでなんでも消せるように
set formatoptions-=tc                               " 整形オプション
set formatoptions+=m                                " 整形オプション，マルチバイト系を追加
                                                    " http://vimwiki.net/?cmd=read&page=%27formatoptions%27&word=formatoptions
set wrapscan                                        " 最後まで検索したら先頭へ戻る
set ignorecase                                      " 大文字小文字無視
set smartcase                                       " 大文字ではじめたら大文字小文字無視しない
set incsearch                                       " インクリメンタルサーチ
"set hlsearch                                        " 検索文字をハイライト
set nobackup                                        " バックアップ取らない
set autoread                                        " 他で書き換えられたら自動で読み直す
set noswapfile                                      " スワップファイル作らない
set hidden                                          " 編集中でも他のファイルを開けるようにする
set showmatch                                       " 括弧の対応をハイライト
set showcmd                                         " 入力中のコマンドを表示
set cursorline                                      " 行カーソル表示
set number                                          " 行番号表示
set list                                            " 不可視文字表示
set listchars=tab:>\                                " 不可視文字の表示方法
set notitle                                         " タイトル書き換えない
set scrolloff=5                                     " 行送り
set laststatus=2                                    " ステータスラインの表示
                                                    " 0: 一番下のウィンドウはステータスラインを表示しない
                                                    " 1: ウィンドウが1つの時はステータスラインを表示しない2つ以上ある場合は、ステータスラインを表示する
                                                    " 2: 常にステータスラインを表示する
set statusline=%<%f\ %m%r%h%w%{'['.(&fenc!=''?&fenc:&enc).']['.&ff.']['.&ft.']'}\ %{g:status}%=%l,%c%V%8P
                                                    " ステータスライン
set ffs=unix,dos,mac                                " 改行文字
set fileencodings=utf-8,cp932,euc-jp,iso-2022-jp    " ファイルの文字コード(前から順番に試していきマッチしたらそこで終了)
set encoding=utf-8                                  " 全てマッチしなかった際のデフォルト
set termencoding=utf-8                              " ターミナルの文字コード（キー入力、モニタ出力）
set ambiwidth=double                                " UTF-8の□や○でカーソル位置がずれないようにする
                                                    " Terminal.appはどっちにしてもダメ，PrivatePortsのiTermでやる
set diffopt=iwhite                                  " diffモードで空白を無視する
syntax on                                           " シンタックスカラーリングオン
filetype indent on                                  " ファイルタイプによるインデントを行う
filetype plugin on                                  " ファイルタイプごとのプラグインを使う

"set wrap                                            " 画面幅で折り返す
"set wildmenu                                        " コマンド補完を強化
"set wildmode=list:full                              " リスト表示，最長マッチ
"set complete+=k                                     " 補完に辞書ファイル追加


colorscheme molokai
let g:molokai_original=0
let g:rehash256=0


"**************************************************************************************
" Tabs & Buffers
"--------------------------------------------------------------------------------------
noremap <C-h> <ESC>:tabprevious<CR>
noremap <C-t> <ESC>:tabnew<CR>
noremap <C-l> <ESC>:tabnext<CR>
noremap <S-Tab> <ESC>:bp<CR>
noremap <Tab> <ESC>:bn<CR>
noremap <S-l> <ESC>:call BufferList()<CR>
let BufferListMaxWidth = 240


"**************************************************************************************                                                                                                                                                                                                                               [4/726]
" MRU
"--------------------------------------------------------------------------------------
let MRU_Max_Entries = 40
let MRU_Window_Height = 30
let MRU_Auto_Close = 0


"**************************************************************************************
" Mouse
"--------------------------------------------------------------------------------------
set mouse=a
set ttymouse=xterm2


"**************************************************************************************
" PHP settings
"--------------------------------------------------------------------------------------

let php_folding=1
let php_sql_query=1
let php_htmlInStrings=1

" html to phtml
set nowrap
filetype plugin indent on
augroup filetypedetect
    au! BufRead,BufNewFile *.html    setfiletype phtml
augroup END

" Check syntax
au BufEnter * let g:status = ""
au BufWritePost *.php let g:status=substitute(system("php -l " . bufname("%")), '\n', " ", "g")
au BufWritePost *.ctp let g:status=substitute(system("php -l " . bufname("%")), '\n', " ", "g")
au BufWritePost *.html let g:status=substitute(system("php -l " . bufname("%")), '\n', " ", "g")
set makeprg=php\ -l\ %
set errorformat=%m\ in\ %f\ on\ line\ %l


"**************************************************************************************
" pやPを押した時に最後にyankしたテキストを貼り付けるようにする |
" http://project-p.jp/halt/?p=1747
"--------------------------------------------------------------------------------------
"
"noremap p "0p


"**************************************************************************************
" Ctrl+gでCtrl+w (for Chrome SecureShell)
"--------------------------------------------------------------------------------------
"
"map <C-g> <C-w>


"**************************************************************************************
" https://github.com/nono/jquery.vim
"--------------------------------------------------------------------------------------
"
au BufRead,BufNewFile jquery.*.js set ft=javascript syntax=jquery


"**************************************************************************************
" Folding
"--------------------------------------------------------------------------------------
map <C-k>m <ESC>:set foldmethod=marker<CR>
map <C-k>s <ESC>:set foldmethod=syntax<CR>
map <C-k>i <ESC>:set foldmethod=indent<CR>
map <C-k>0 <ESC>:set foldlevel=0<CR>
map <C-k>1 <ESC>:set foldlevel=1<CR>
map <C-k>2 <ESC>:set foldlevel=2<CR>
map <C-k>3 <ESC>:set foldlevel=3<CR>

set foldclose=all
set foldlevel=0
set foldmethod=syntax




"let g:multi_cursor_use_default_mapping=0
"let g:multi_cursor_next_key='<C-n>'
"let g:multi_cursor_prev_key='<C-p>'
"let g:multi_cursor_skip_key='<C-x>'
"let g:multi_cursor_quit_key='<Esc>'
"let g:multi_cursor_start_key='<F6>'



autocmd FileType gitv call s:my_gitv_settings()
function! s:my_gitv_settings()
    setlocal iskeyword+=/,-,.
    nnoremap <silent><buffer> C :<C-u>Git checkout <C-r><C-w><CR>
    nnoremap <buffer> <Space>rb :<C-u>Git rebase <C-r>=GitvGetCurrentHash()<CR><Space>
    nnoremap <buffer> <Space>R :<C-u>Git revert <C-r>=GitvGetCurrentHash()<CR><CR>
    nnoremap <buffer> <Space>h :<C-u>Git cherry-pick <C-r>=GitvGetCurrentHash()<CR><CR>
    nnoremap <buffer> <Space>rh :<C-u>Git reset --hard <C-r>=GitvGetCurrentHash()<CR>
    nnoremap <silent><buffer> t :<C-u>windo call <SID>toggle_git_folding()<CR>1<C-w>w
endfunction

function! s:gitv_get_current_hash()
  return matchstr(getline('.'), '\[\zs.\{7\}\ze\]$')
endfunction

autocmd FileType git setlocal nofoldenable foldlevel=0
function! s:toggle_git_folding()
  if &filetype ==# 'git'
    setlocal foldenable!
  endif
endfunction



" QuickFixウィンドウでもプレビューや絞り込みを有効化
let QFixWin_EnableMode = 1

" QFixHowm/QFixGrepの結果表示にロケーションリストを使用する/しない
let QFix_UseLocationList = 1

" 以前と同じ動作(QuickFixを使用する)に戻すには以下を設定してください。
" QFixHowm/QFixGrepの結果表示にロケーションリストを使用する/しない
let QFix_UseLocationList = 0


"**************************************************************************************
" SnipMate reload all snippets
"--------------------------------------------------------------------------------------
noremap <F1> <ESC>:call ReloadAllSnippets()<CR>


"**************************************************************************************
" 各種モード切替
"--------------------------------------------------------------------------------------
noremap <C-m>2 <ESC>:set tabstop=2 shiftwidth=2 softtabstop=0<CR>
noremap <C-m>4 <ESC>:set tabstop=4 shiftwidth=4 softtabstop=0<CR>
noremap <C-m>s <ESC>:set expandtab<CR>
noremap <C-m>t <ESC>:set noexpandtab<CR>
noremap <C-m>p <ESC>:set paste<CR>
noremap <C-m>n <ESC>:set nopaste<CR>


"**************************************************************************************
" Ctrl+xで:q
"--------------------------------------------------------------------------------------
"
noremap <C-x> <ESC>:q<CR>




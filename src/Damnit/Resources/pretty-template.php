<?php
/**
* Template file for Damnit's pretty error output.
* Check the $v global variable (stdClass) for what's available
* to work with.
* @var $v
*/
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Damn it! - There was an error.</title>

    <link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/normalize/2.1.0/normalize.css">
    <style>
      body {
        font: 14px helvetica, arial, sans-serif;
        color: #2B2B2B;
        background-color: #DADADA;

        padding:0;
        margin: 0;
      }

      header {
        padding: 30px 20px;
        border-bottom: 1px solid #B7B7B7;
        border-top: 6px solid #B7B7B70;
      }

      .exc-title {
        margin: 0;
        color: #616161;

        text-shadow: 0 1px 2px rgba(0, 0, 0, .1);
      }
        .exc-title-primary { color: #CD3F3F; }

      .exc-message {
        font-size: 32px;
        margin: 5px 0;
      }

      .frames-container {
        float: left;
        min-width: 30%;
        max-width: 480px;
      }

      .details-container {
        float: right;
        max-width: 100%;
        min-width: 70%;
      }

      .frame {
        height: 20px;
        padding: 14px;
        background: #F3F3F3;
        cursor: pointer;
      }
        .frame.active {
          background-color: #4288CE;
          color: #F3F3F3;
        }

        .frame:not(.active):hover {
          background: #BEE9EA;
        }

        .frame-file {
          font-family: consolas, monospace;
        }
          .frame-line {
            font-weight: bold;
            color: #4288CE;
          }
            .active .frame-line { color: #BEE9EA; }
          .frame-line:before {
            content: ":";
          }

      .frame-code {
        padding: 10px;
        background: #BDBDBD;
      }

      .code-block {
        padding: 10px;
        margin: 0;
        border: 1px solid rgba(0, 0, 0, .4);
        border-radius: 4px;
        box-shadow: 0 0 6px rgba(0, 0, 0, .2);
      }
        .linenums {
          margin: 0;
        }

      /* prettify code style
       Uses the Doxy theme as a base */
      pre .str, code .str { color: #79E3E1; }  /* string  */
      pre .kwd, code .kwd { color: #FDFF62;  font-weight: bold; }  /* keyword*/
      pre .com, code .com { color: #A5A5A5; font-weight: bold; } /* comment */
      pre .typ, code .typ { color: #E16CA1; }  /* type  */
      pre .lit, code .lit { color: #49DF9D; }  /* literal */
      pre .pun, code .pun { color: #51D743; font-weight: bold;  } /* punctuation  */
      pre .pln, code .pln { color: #BBBBBB; }  /* plaintext  */
      pre .tag, code .tag { color: #9c9cff; }  /* html/xml tag  */
      pre .htm, code .htm { color: #dda0dd; }  /* html tag */
      pre .xsl, code .xsl { color: #d0a0d0; }  /* xslt tag */
      pre .atn, code .atn { color: #46eeee; font-weight: normal;} /* html/xml attribute name */
      pre .atv, code .atv { color: #EEB4B4; }  /* html/xml attribute value  */
      pre .dec, code .dec { color: #3387CC; }  /* decimal  */

      a {
        text-decoration: none;
      }
      pre.prettyprint, code.prettyprint {
        font-family: consolas, monospace;
        background: #272727;
        color: #929292;
      }

      pre.prettyprint {
        white-space: pre-wrap;
      }

      pre.prettyprint a, code.prettyprint a {
         text-decoration:none;
      }
    </style>
  </head>
  <body onload="__damnit_ready();">
    <div class="container">
      <header>
        <div class="exception">
          <h3 class="exc-title">
            <?php foreach($v->name as $i => $nameSection): ?>
              <?php if($i == count($v->name) - 1): ?>
                <span class="exc-title-primary"><?php echo $nameSection ?></span>
              <?php else: ?>
                <?php echo $nameSection . '\\' ?>
              <?php endif ?>
            <?php endforeach ?>
          </h3>
          <p class="exc-message">
            <?php echo $v->message ?>
          </p>
        </div>
      </header>
      <div class="stack-container">
        <div class="frames-container clearfix <?php echo (!$v->hasFrames ? 'empty' : '') ?>">
          <?php foreach($v->frames as $i => $frame): ?>
            <div class="frame <?php echo ($i == 0 ? 'active' : '') ?>">
              <span class="frame-file"><?php echo $frame->getFile() ?><span class="frame-line"><?php echo $frame->getLine() ?></span></span>
            </div>
          <?php endforeach ?>
        </div>
        <div class="details-container clearfix">
          <div class="frame-code <?php echo (!$v->hasFrames ? 'empty' : '') ?>">
            <pre class="code-block prettyprint linenums:42">&lt;?php /* hi */ if("hi") { (bool) true && 11.3 + false && fc(); }</pre>
          </div>
        </div>
      </div>
    </div>

    <script src="http://cdnjs.cloudflare.com/ajax/libs/prettify/r224/prettify.js"></script>
    <script>
      window.__damnit_ready = function() {
        prettyPrint();
      };
    </script>
  </body>
</html>

<?php
/*
 * 读取模板类
 * */
final class View
{
  private $_data = array();

  public function render($templateFile, $variables = null)
  {
    global $basePath;
    static $template;
    if (!isset($template)) {
      if (isset($_SESSION['preview'])) {
        $template = $_SESSION['preview'];
      } else {
        $template = $GLOBALS['_CFG']['template'];
      }
    }
    $this->assign('tpldir', $template ? ($basePath . 'templates/' . $template) : '');
    $this->assign('scripts', $this->renderJs());
    $this->assign('styles', $this->renderCss());

    if (isset($variables) && is_array($variables)) {
      $this->assign($variables);
    }
    extract($this->_data, EXTR_OVERWRITE);

    if ($template && is_file(TPLPATH . '/' . $template . '/views/' . $templateFile)) {
      include TPLPATH . '/' . $template . '/views/' . $templateFile;
    } else if (is_file($basePath . 'templates/'  . '/default/views/' . $templateFile)) {
      include $basePath . 'templates/'  . '/default/views/' . $templateFile;
    } else {
      echo 'View file <em>' . $templateFile . '</em> not found.';
      exit;
    }
  }

  public function assign($key, $value = null)
  {
    if (is_array($key)) {
      foreach ($key as $k => $value) {
        $this->_data[$k] = $value;
      }
    } else {
      $this->_data[$key] = $value;
    }
    return $this;
  }

  public function setTitle($title, $keywords = '', $description = '', $var1 = '', $var2 = '', $var3 = '', $var4 = '', $var5 = '', $var6 = '')
  {
    $this->assign('docTitle', $title);
    $this->assign('docKeywords', $keywords);
    $this->assign('docDescription', $description);
    $this->assign('docvar1', $var1);
    $this->assign('docvar2', $var2);
    $this->assign('docvar3', $var3);
    $this->assign('docvar4', $var4);
    $this->assign('docvar5', $var5);
    $this->assign('docvar6', $var6);
    return $this;
  }

  public function addJs($path)
  {
    if (!isset($this->_data['scripts'])) {
      $this->_data['scripts'] = array();
    }
    $this->_data['scripts'][] = $path;
    return $this;
  }

  public function renderJs()
  {
    static $scripts;
    if (!isset($scripts)) {
      $scripts = '';
      if (isset($this->_data['scripts'])) {
        foreach ($this->_data['scripts'] as $path) {
          $scripts .= '<script type="text/javascript" src="' . $path . '"></script>' . PHP_EOL;
        }
      }
    }
    return $scripts;
  }

  public function addCss($path)
  {
    if (!isset($this->_data['styles'])) {
      $this->_data['styles'] = array();
    }
    $this->_data['styles'][] = $path;
    return $this;
  }

  public function renderCss()
  {
    static $styles;
    if (!isset($styles)) {
      $styles = '';
      if (isset($this->_data['styles'])) {
        foreach ($this->_data['styles'] as $path) {
          $styles .= '<link rel="stylesheet" href="' . $path . '" type="text/css">' . PHP_EOL;
        }
      }
    }
    return $styles;
  }
  public function end()
  {
      global $db,$compress;
    $output = str_replace(array('<!--<!---->','<!---->-->','<!--fck-->','<!--fck','fck-->','<!---->','<!--->','<!---','--->','',"\r"),'',ob_get_contents());
    $$GLOBALS['db']->close();

    ob_end_clean();
    ob_end_flush();
    if(isset($compress) && $compress){
     echo preg_replace('/\s+/', ' ', $output);
    }else{
     echo $output;
    }
     unset($output);exit;
  }

}
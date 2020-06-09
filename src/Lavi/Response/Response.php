<?php

namespace Lavi\Response;

class Response
{
    public function send($content = null): Response
    {
        $this->sendContent($content);
        $this->flushBuffer();

        return $this;
    }

    public function withHeader()
    {

    }

    private function flushBuffer()
    {
        flush();
    }

    private function sendContent($content)
    {
        if (is_array($content)) {
            $content = json_encode($content);
        }

        echo $content;

        return true;
    }
}
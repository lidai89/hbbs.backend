<?php declare(strict_types=1);

namespace lzx\core;

class JSON
{
    private $data;
    private $string;

    public function __construct(array $data = null)
    {
        $this->setData($data);
    }

    public function setData(array $data = null)
    {
        if ($data) {
            $this->data = $data;
            $this->string = null;
        } else {
            $this->data = [];
            $this->string = '{}';
        }
    }

    public function __toString()
    {
        // string cache
        if (!$this->string) {
            $this->string = json_encode($this->data, JSON_NUMERIC_CHECK | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            if ($this->string === false) {
                $this->string = '{"error":"json encode error"}';
            }
        }
        return $this->string;
    }
}

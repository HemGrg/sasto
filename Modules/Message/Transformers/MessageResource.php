<?php

namespace Modules\Message\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Modules\Front\Transformers\ProductResource;
use Modules\Product\Entities\Product;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'chat_room_id' => $this->chat_room_id,
            'sender_id' => $this->sender_id,
            'read_at' => $this->read_at,
            'key' => $this->key,
            'created_at' => $this->created_at,
            'type' => $this->type,
            'message' => $this->wrapURLs($this->message),
            'file_url' => $this->when($this->file, $this->fileUrl()),
            'product' => $this->when($this->type === 'product' && $this->key, $this->getProduct($this->key)),
            'is_image' => $this->when($this->type === 'file', $this->isImage($this->file)),
        ];
    }

    private function getProduct($id)
    {
        if (!$id) {
            return null;
        }
        return ProductResource::make(Product::find($id))->hide([
            'highlight',
            'description',
            'meta_title',
            'meta_keyword',
            'meta_description',
            'meta_keyphrase',
            'brand_id',
            'discount',
            'delivery_charge',
            'best_seller',
            'essential',
            'overview',
            'offer_id',
            'summary',
            'quantity',
        ]);
    }

    private function wrapURLs($text, $new_window = true)
    {
        $url_pattern = '/(?:(?:https?|ftp):\/\/)?(?:\S+(?::\S*)?@)?(?:(?!10(?:\.\d{1,3}){3})(?!127(?:\.\d{1,3}){3})(?!169\.254(?:\.\d{1,3}){2})(?!192\.168(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\x{00a1}\-\x{ffff}0-9]+-?)*[a-z\x{00a1}\-\x{ffff}0-9]+)(?:\.(?:[a-z\x{00a1}\-\x{ffff}0-9]+-?)*[a-z\x{00a1}\-\x{ffff}0-9]+)*(?:\.(?:[a-z\x{00a1}\-\x{ffff}]{2,})))(?::\d{2,5})?(?:\/[^\s]*)?/iu';
        $target = $new_window ? '_blank' : '';

        return preg_replace_callback($url_pattern, function (array $url_array) use ($target) {
            $url = implode($url_array, '');
            $protocol_pattern = '/^(?:(?:https?|ftp):\/\/)/iu';
            $href = preg_match($protocol_pattern, $url) ? $url : 'http://' . $url;
            return '<a href="' . $href . '" target="' . $target . '">' . $url . '</a>';
        }, $text);
    }

    private function isImage()
    {
        $allowedMimeTypes = ['image/jpeg', 'image/gif', 'image/png', 'image/bmp', 'image/svg+xml'];
        $contentType = mime_content_type(Storage::path($this->file));
        return in_array($contentType, $allowedMimeTypes);
    }
}

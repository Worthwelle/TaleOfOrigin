<?php

namespace TaleOfOrigin;

use Illuminate\Database\Eloquent\Model;

class SlugModel extends Model
{   
    /**
     * Force the slug to be lowercase and remove spaces. If no slug is
     * specified, use the name field by default.
     * 
     * @return string
     */
    protected function cleanSlug() {
        if( !isset( $this->slug ) || $this->slug == '' ) {
            $this->slug = $this->title;
        }
        elseif ($this->slug == str_slug($this->slug)) {
            return;
        }
        return $this->slug = str_slug($this->slug);
    }
    
    /**
     * Override the save function to verify a name is present and to clean the
     * slug.
     * 
     * @todo remove special characters from slugs
     * 
     * @param array $options
     */
    public function save(array $options = array()) {
        $this->cleanSlug();
        parent::save($options);
    }
}

import { registerBlockType } from '@wordpress/blocks';

registerBlockType(
  'pg/basic',
  {
    title: "Basic Block",
    description: "Este es nuestro primer bloque",
    icon: "smiley",
    category: "layout",
    edit: ()=> <h2>Hello World, para el editor</h2>,
    save: ()=> <h2>Hello World, para el front</h2>
  }
)
import { registerBlockType } from '@wordpress/blocks';
import { TextControl,PanelBody, PanelRow  } from '@wordpress/components';
import { InspectorControls } from '@wordpress/block-editor'; // Esta librería está disponible desde que instalamos el paquete "wordpress/scripts desde NPM
import ServerSideRender from '@wordpress/server-side-render'; 



registerBlockType(
  'pg/basic',
  {
    title: "Basic Block",
    description: "Este es nuestro primer bloque",
    icon: "smiley",
    category: "layout",
    attributes: {
      content: {
        type: "string",
        default: "Hello World"
      }
    },
    edit: (props)=> {
      const { attributes: {content}, setAttributes, className, isSelected} = props;
      const handlerOnChangeInput = (newContent) => {
        // el valor del input reflejado
        setAttributes({content:newContent})
        
      }
      
      // componente fragment <> </>
      return <>  
              <InspectorControls>
                  <PanelBody // Primer panel en la sidebar
                      title="Modificar texto del Bloque Básico"
                      initialOpen={ false }
                  >
                      <PanelRow>
                          <TextControl
                              label="Complete el campo" // Indicaciones del campo
                              value={ content } // Asignación del atributo correspondiente
                              onChange={ handlerOnChangeInput } // Asignación de función para gestionar el evento OnChange
                          />
                      </PanelRow>
                  </PanelBody>
              </InspectorControls>
              <ServerSideRender // Renderizado de bloque dinámico
                  block="pg/basic" // Nombre del bloque
                  attributes={ props.attributes } // Se envían todos los atributos
              />
          </>
 
    },
    save: ()=>  null // para buscar una función de renderizado en php
  }
)
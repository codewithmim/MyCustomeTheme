wp.blocks.registerBlockType('mycustomtheme/greeting', {
    title: 'Custom Greeting',
    icon: 'smiley',
    category: 'common',
    attributes: {
      greeting: {
        type: 'string',
        default: 'Welcome to MyCustomTheme!',
      },
    },
    edit: function(props) {
      return wp.element.createElement(
        'div',
        {},
        wp.element.createElement('input', {
          type: 'text',
          value: props.attributes.greeting,
          onChange: (e) => props.setAttributes({ greeting: e.target.value }),
        })
      );
    },
    save: function() {
      return null;
    },
  });
  
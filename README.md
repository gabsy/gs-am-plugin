# Gabi Schiopu AM API Plugin

**LE**: I also implemented the widgets settings update using a different mock api, through PATCH method. The updates error handling is not properly done on the user view, just through console for now.

The implementation approach of this project is to encapsulate all functionality within a single, self-contained and reusable component. This component is responsible for fetching displaying widgets and handling all related settings internally through its child components. It display the widgets by iterating the ProductWidgetSetup component. This design choice promotes modularity and reusability, allowing the component to be easily integrated into different parts of an application without requiring external configuration, using API URL passed as a prop, eventually stored as an environment variable.

```ProductWidgetSetup``` component is composed of the ```ProductWidget``` and a related settings component. All the settings states for a widget are managed here, ~~updates can be perfomed (not implemented here)~~ records updating through an API call, passing property/value pairs for ```active```, ```isLinked``` and ```widgetColor```, at the time of their state updates.

```ProductWidget``` component it is also built as a self-contained, reusable component, used in this context for previewing the setting updates but also ready to be used alone. (well, it does have the logo svg dependency that can be moved to be consumed as prop, not implemented at the time of writing this text).

The project also includes separate custom UI related components like ```Checkbox```, ```Toggle```, ```Tooltip``` and ```Svgs```. It stores the needed SVGs ( logo, infoIcon ...) as exported components that can be easily imported and rendered as svg markup.

https://github.com/gabsy/greenspark/assets/871700/e079138b-a0ff-4e2d-be9a-a8d30753e71e

## Install

It requires Node 18.x and Npm 9.x.

Run ```npm install```.

Run ```npm run dev```, project will start on ```https://localhost:5173```

## Storybook
Storybook is used for developing and documenting components in isolation. You can run Storybook using ```npm run storybook``` and visit ```localhost:6006``` to view the added components.

<img width="1325" alt="CleanShot 2024-03-17 at 20 54 29@2x" src="https://github.com/gabsy/greenspark/assets/871700/0a491815-17c8-4323-8695-ac3bcfcdd037">

## Testing
The project uses Vitest for testing. Test files are located alongside the components they are testing. Run ```npm run test``` to run the tests.

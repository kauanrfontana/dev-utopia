import { NgModule } from "@angular/core";
import { ProfileComponent } from "./profile.component";
import { Route, RouterModule } from "@angular/router";
import { SharedModule } from "../shared/shared.module";

const Route: Route = {
  path: "",
  component: ProfileComponent,
};

@NgModule({
  declarations: [ProfileComponent],
  imports: [SharedModule, RouterModule.forChild([Route])],
})
export class ProfileModule {}

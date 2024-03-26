import { Pipe, PipeTransform } from "@angular/core";

@Pipe({
  name: "cutLabel",
})
export class CutLabelPipe implements PipeTransform {
  transform(value: string, tam: number) {
    if (value?.length > tam) {
      return value?.substring(0, tam - 3) + "...";
    }
    return value;
  }
}

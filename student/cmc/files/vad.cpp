#include <fstream>
#include <iostream>
#include <iomanip>
#include <vector>
#include <cstring>
#include <algorithm>
#include <cmath>

//https://audiocoding.ru/articles/2008-05-22-wav-file-structure/


enum COLORS {
  GRAY,
  RED,
  GREEN,
  YELLOW,
  BLUE,
  PURPLE,
  CYAN,
  TRANSPARENT,
  NOCOLOR
};

char COLOR_CODE[][8] = {
	"\033[40m",
	"\033[41m",
	"\033[42m",
	"\033[43m",
	"\033[44m",
	"\033[45m",
	"\033[46m",
	"\033[37m",
  "\033[0m"
};

void print(const std::string &string) {
  std::cout << string << std::endl;
}

template<class T>
void print(const std::vector<T> &data, int limit = 0) {
  std::cout << data.size() << " samples: ";
  std::cout << "[";
  std::cout << std::fixed << std::setprecision(3);
  if (limit == 0 || (int)data.size() <= limit) {
    for (int i = 0; i < (int)data.size(); i++) {
      std::cout << data[i] << " ";
    }
  } else {
    for (int i = 0; i < limit / 2; i++) {
      std::cout << data[i] << " ";
    }
    std::cout << "... ";
    for (int i = 0; i < (limit - 1) / 2; i++) {
      std::cout << data[data.size() - 1 - i] << " ";
    }
  }
  std::cout << "]";
  std::cout << std::endl;
}

template<class T>
void print_with_timeline(const std::vector<T> &data,
                         double single_duration,
                         std::string units_name,
                         int row_limit) {
  std::cout << std::fixed << std::setprecision(3);
  for (int i = 0; i < (int)data.size(); i++) {
    if (i % row_limit == 0) {
      std::cout << std::setw(8) << single_duration * i << " " << units_name << " |  ";
    }
    std::cout << data[i] << " ";
    if ((i + 1) % row_limit == 0 || i + 1 == (int)data.size()) {
      std::cout << " | " << std::setw(8) << single_duration * (i + 1) << " " << units_name << std::endl;
    }
  }
  std::cout << std::endl;
}

template<class T>
void print_with_colored_timeline(const std::vector<T> &data,
                                 const std::vector<bool> &mask,
                                 double single_duration,
                                 std::string units_name,
                                 int row_limit) {
  std::cout << std::fixed << std::setprecision(3);
  for (int i = 0; i < (int)data.size(); i++) {
    if (i % row_limit == 0) {
      std::cout << std::setw(8) << single_duration * i << " " << units_name << " |  ";
    }

    if (mask[i]) {
      std::cout << COLOR_CODE[GREEN];
    }

    std::cout << data[i] << " ";

    if (mask[i]) {
      std::cout << COLOR_CODE[NOCOLOR];
    }

    if ((i + 1) % row_limit == 0 || i + 1 == (int)data.size()) {
      std::cout << " | " << std::setw(8) << single_duration * (i + 1) << " " << units_name << std::endl;
    }
  }
  std::cout << std::endl;
}

struct WavHeader {
  char chunkId[4]; // 'RIFF'
  unsigned int chunkSize; // file size - 8
  char format[4]; // 'WAVE'
  char subchunk1Id[4]; // 'fmt '
  unsigned int subchunk1Size; // 16 for 'pcm' format
  unsigned short audioFormat; // 1 for 'pcm' format
  unsigned short numChannels; // 1 for 'mono' format
  unsigned int sampleRate;
  unsigned int byteRate;
  unsigned short blockAlign; // byte per sample (included all channels)
  unsigned short bitsPerSample;
  char subchunk2Id[4]; // 'data'
  unsigned int subchunk2Size; // byte (file size - 44)
};


int get_duration_samples(const WavHeader &header) {
  return header.subchunk2Size / header.blockAlign;
}

double get_duration_seconds(const WavHeader &header) {
  return get_duration_samples(header) / double(header.sampleRate);
}

void print_wav_header_info(const WavHeader &header) {
  std::cout << "Channels   : " << header.numChannels << std::endl;
  std::cout << "Sample Rate: " << header.sampleRate << std::endl;
  std::cout << "Precision  : " << header.bitsPerSample << "-bit" << std::endl;
  std::cout << "Duration   : " << std::fixed << std::setprecision(3)
                               << get_duration_seconds(header) << " seconds = "
                               << get_duration_samples(header) << " samples" << std::endl;
  std::cout << "File size  : " << header.subchunk2Size << " byte" << std::endl;
  std::string format = header.audioFormat == 1 ? "16-bit Signed Integer PCM" : "unknown";
  std::cout << "Format     : " << format << std::endl;
}

std::vector<int> load_wav(const std::string &wav_file_path, int *sample_rate) {
  // open file
  std::ifstream input_stream(wav_file_path.c_str(), std::ios::binary);
  if (!input_stream) {
    print(wav_file_path + ": cannot open file");
    exit(1);
  }

  // read header
  WavHeader header;
  input_stream.read((char *) &header, sizeof(header));
  if (strncmp(header.format, "WAVE", 4) != 0) {
    print(wav_file_path + ": file is not wav.");
    exit(2);
  }
  print(wav_file_path);
  print_wav_header_info(header);
  *sample_rate = header.sampleRate;

  // read data
  int samples_number = get_duration_samples(header);
  std::vector<int> data(samples_number);
  for (int i = 0; i < samples_number; i++) {
    short sample;
    input_stream.read((char *) &sample, sizeof(short));
    data[i] = sample;
  }
  input_stream.close();

  // print info
  print(data, 20);
  int minimum = *std::min_element(data.begin(), data.end());
  int maximum = *std::max_element(data.begin(), data.end());
  std::cout << "Range: [" << minimum << ":" << maximum << "]" << std::endl; 

  return data;
}

double get_segment_energy(const std::vector<int> &data, int start, int end) {
  double energy = 0;
  for (int i = start; i < end; i++) {
    energy += data[i] * data[i] / (end - start);
  }
  energy = sqrt(energy) / 32768;
  return energy;
}

std::vector<double> get_segments_energy(const std::vector<int> &data, int segment_duration) {
  std::vector<double> segments_energy;
  for (int segment_start = 0; segment_start < (int)data.size(); segment_start += segment_duration) {
    int segment_stop = std::min(segment_start + segment_duration, (int)data.size());
    double energy = get_segment_energy(data, segment_start, segment_stop);
    segments_energy.push_back(energy);
  }
  return segments_energy;
}

std::vector<bool> get_vad_mask(const std::vector<double> &data, double threshold) {
  std::vector<bool> vad_mask(data.size());
  for (int i = 0; i < (int)data.size(); i++) {
    vad_mask[i] = data[i] > threshold;
    // std::cout << data[i] << '>' << threshold << '=' << vad_mask[i] << std::endl;
  }
  return vad_mask;
}

int sec2samples(double seconds, int sample_rate) {
  return int(seconds * sample_rate);
}

struct Segment {
  int start;
  int stop;
};

void print_segments(const std::vector<Segment> &segments,
                    double single_duration,
                    std::string units_name) {
  std::cout << std::fixed << std::setprecision(3);
  double total_duration = 0.0;
  double min_duration = 0.0;
  double max_duration = 0.0;
  for (int i = 0; i < (int)segments.size(); i++) {
    double start_units = segments[i].start * single_duration;
    double stop_units = segments[i].stop * single_duration;
    double duration_units = stop_units - start_units;
    total_duration += duration_units;
    if (i == 0 || min_duration > duration_units)
      min_duration = duration_units;
    if (i == 0 || max_duration < duration_units)
      max_duration = duration_units;
    std::cout << std::setw(5) << i << ": "
              << std::setw(6) << start_units << " - " << std::setw(6) << stop_units
              << " (" << duration_units << ' ' << units_name << ')' << std::endl;
  }
  std::cout << "Min  duration : " << min_duration << ' ' << units_name << std::endl;
  std::cout << "Mean duration : " << total_duration / segments.size() << ' ' << units_name << std::endl;
  std::cout << "Max  duration : " << max_duration << ' ' << units_name << std::endl;
  std::cout << "Total segments: " << segments.size() << std::endl;
  std::cout << "Total duration: " << total_duration << ' ' << units_name << std::endl;
}


std::vector<Segment> mask_compress(const std::vector<bool> &data) {
  std::vector<Segment> segments;
  if (data.size() == 0) {
    return segments;
  }
  int start = -1, stop = -1;
  if (data[0] == 1)
    start = 0;
  for (int i = 0; i + 1 < (int)data.size(); i++) {
    if (data[i] == 0 and data[i + 1] == 1) {
      start = i + 1;
    }
    if (data[i] == 1 and data[i + 1] == 0) {
      stop = i + 1;
      segments.push_back(Segment{start, stop});
    }
  }
  if (data[data.size() - 1] == 1) {
    stop = data.size();
    segments.push_back(Segment{start, stop});
  }
  return segments;
}

int main(int argc, char** argv) {
  if (argc != 4) {
    print("Incorrect args. Example:");
    print("./open example/women.wav 0.1 0.01");
    return 1;
  }

  std::string wav_file_path(argv[1]);
  double segment_duration = atof(argv[2]);
  double vad_threshold = atof(argv[3]);

  int sample_rate = 0;
  std::vector<int> audio = load_wav(wav_file_path, &sample_rate);

  int segment_duration_samples = sec2samples(segment_duration, sample_rate);
  std::vector<double> segments_energy = get_segments_energy(audio, segment_duration_samples);
  std::vector<bool> vad_mask = get_vad_mask(segments_energy, vad_threshold);
  std::vector<Segment> segments = mask_compress(vad_mask);

  // print_with_timeline(vad_mask, segment_duration, "sec", 10);
  print_with_colored_timeline(segments_energy, vad_mask, segment_duration, "sec", 10);
  print_segments(segments, segment_duration, "sec");
  return 0;
}
